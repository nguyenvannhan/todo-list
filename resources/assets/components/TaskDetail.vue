<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-4">Task Detail</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <p class="font-weight-bold">
                                    {{ this.todoItem.title }}
                                </p>
                            </div>
                        </div>
                        <div class="col-12" v-if="this.todoItem.description">
                            <div class="form-group">
                                <p v-html="this.todoItem.description"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label
                                    >Status:
                                    <strong>{{
                                        this.todoItem.completed
                                            ? "Completed"
                                            : "Doing"
                                    }}</strong></label
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    Assigned User:
                                    <strong>
                                        {{
                                            this.todoItem.assigned_user
                                                ? this.todoItem.assigned_user
                                                      .name
                                                : ""
                                        }}
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    mounted() {
        this.fetchTodoItem();
    },
    data() {
        return {
            todoItem: {}
        };
    },
    methods: {
        async fetchTodoItem() {
            this.todoItem = await this.$store.dispatch(
                "todo/getTodoItem",
                this.$route.params.id
            );
        }
    }
};
</script>

<style></style>
