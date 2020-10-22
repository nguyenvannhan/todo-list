<template>
    <div class="TodoList row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-2">
                <div class="card-body">
                    <div
                        class="d-flex justify-content-between border rounded border-gray mb-3 px-3 py-1 todo-item"
                        :class="todoItem.completed ? 'completed' : ''"
                        v-for="todoItem in this.todoList.data"
                        :key="todoItem.id"
                    >
                        <div class="pr-2">
                            <div class="mb-1">
                                <a class="text-dark title" href="#">{{
                                    todoItem.title
                                }}</a>
                            </div>
                            <span class="font-weight-bold">
                                Assigned To {{ todoItem.assigned_user.name }}
                            </span>
                        </div>
                        <div
                            class="action d-flex align-items-center justify-content-end"
                            v-if="!todoItem.completed"
                        >
                            <router-link
                                :to="{
                                    name: 'TaskEdit',
                                    params: { id: todoItem.id }
                                }"
                                class="btn btn-outline-primary mx-1 btn-sm"
                                v-if="user.role_id"
                                >Edit</router-link
                            >
                            <a
                                href="#"
                                class="btn btn-outline-success mx-1 btn-sm"
                                @click.prevent="markComplete(todoItem.id)"
                                >Completed</a
                            >
                            <a
                                href="#"
                                class="btn btn-outline-danger mx-1 btn-sm"
                                v-if="user.role_id"
                                @click.prevent="deleteTodoItem(todoItem.id)"
                                >Delete</a
                            >
                        </div>
                        <div
                            v-else
                            class="d-flex align-items-center justify-content-end"
                        >
                            <span
                                class="btn btn-outline-success btn-sm
                            rounded-circle"
                            >
                                <CIcon name="cil-check-circle"></CIcon>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card todo-pagination-card">
                <div class="card-body">
                    <nav class="text-center">
                        <Paginate
                            :page-count="totalPage"
                            :page-range="5"
                            :prev-text="'Prev'"
                            :prev-class="'page-item'"
                            :prev-link-class="'page-link'"
                            :next-text="'Next'"
                            :next-class="'page-item'"
                            :next-link-class="'page-link'"
                            :container-class="
                                'pagination justify-content-center'
                            "
                            :page-class="'page-item'"
                            :page-link-class="'page-link'"
                            :click-handler="updatePage"
                        >
                            >
                        </Paginate>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import Paginate from "vuejs-paginate";

export default {
    props: {
        user: { type: Object }
    },
    components: {
        Paginate
    },
    mounted() {
        this.$store.dispatch("todo/getTodoList", {
            status: this.$route.params.status
        });
    },
    computed: {
        ...mapState({
            todoList: state => state.todo.todoList
        }),
        totalPage: function() {
            return this.todoList.meta ? this.todoList.meta.last_page : 0;
        },
        currentPage: function() {
            return this.todoList.meta ? this.todoList.meta.current_page : 0;
        }
    },
    methods: {
        updatePage(page) {
            this.$store.dispatch("todo/getTodoList", {
                status: this.$route.params.status,
                page: page
            });
        },
        markComplete(id) {
            let result = this.$store.dispatch("todo/updateTodoItem", {
                id: id,
                data: {
                    completed: true
                }
            });

            if (result) {
                this.updatePage(this.currentPage);

                this.$swal({
                    icon: "success",
                    title: "Task completed"
                });
            }
        },

        deleteTodoItem(id) {
            let storeAction = this.$store;
            const updateOptions = {
                status: this.$route.params.status,
                page: this.currentPage
            };
            const Swal = this.$swal;

            this.$swal({
                title: "<strong>Delete Task</strong>",
                icon: "info",
                html: "<span>Do you really want to delete task?</span>",
                showCancelButton: true,
                showConfirmButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let result = storeAction.dispatch(
                        "todo/deleteTodoItem",
                        id
                    );

                    if (result) {
                        storeAction.dispatch("todo/getTodoList", updateOptions);

                        Swal({
                            icon: "success",
                            title: "Delete Successfully!"
                        });
                    } else {
                        Swal({
                            icon: "error",
                            title: "Delete Failed!"
                        });
                    }
                }
            });
        }
    }
};
</script>

<style lang="scss" scoped>
.todo-item {
    &.completed {
        .title {
            text-decoration: line-through;
        }
    }
}
</style>
