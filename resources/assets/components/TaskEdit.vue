<template>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <CForm @submit.prevent="saveTodoItem">
                        <h1>Edit Task</h1>

                        <div class="alert alert-danger" v-if="hasError">
                            <p>
                                Edit Task Fail
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <CInput
                                        label="Title"
                                        placeholder="Enter title"
                                        v-model="todoItem.title"
                                    />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div>
                                        <wysiwyg
                                            v-model="todoItem.description"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <Select2
                                        v-model="todoItem.completed"
                                        :options="completeOptions"
                                        :settings="{
                                            minimumResultsForSearch: -1
                                        }"
                                    ></Select2>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Assigned User</label>
                                    <Select2
                                        v-model="user_id"
                                        :options="userOptions"
                                    ></Select2>
                                </div>
                            </div>

                            <CCol col="12" class="text-center">
                                <CButton
                                    color="primary"
                                    class="px-4"
                                    type="submit"
                                    >Save</CButton
                                >
                            </CCol>
                        </div>
                    </CForm>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Select2 from "v-select2-component";

import { mapState } from "vuex";

export default {
    mounted() {
        this.$store.dispatch("user/getUserList");
        this.fetchTodoItem();
    },
    computed: {
        ...mapState({
            userList: state => state.user.userList
        }),
        userOptions: function() {
            return this.userList
                ? this.userList.map(item => {
                      item.text = item.name;

                      return item;
                  })
                : [];
        },
        user_id: {
            set: function(value) {
                this.todoItem.user_id = value;
            },
            get: function() {
                return this.todoItem.assigned_user
                    ? this.todoItem.assigned_user.id
                    : 0;
            }
        }
    },
    data() {
        return {
            todoItem: {},
            loading: true,
            hasError: false,
            completeOptions: [
                {
                    id: false,
                    text: "Not Complete"
                },
                {
                    id: true,
                    text: "Completed"
                }
            ]
        };
    },
    components: {
        Select2
    },
    methods: {
        async fetchTodoItem() {
            this.todoItem = await this.$store.dispatch(
                "todo/getTodoItem",
                this.$route.params.id
            );

            this.todoItem.user_id = this.todoItem.assigned_user.id;

            this.loading = false;
        },

        async saveTodoItem() {
            let result = await this.$store.dispatch("todo/updateTodoItem", {
                id: this.todoItem.id,
                data: this.todoItem
            });

            if (result) {
                let swal = this.$swal({
                    title: "Update Successfully",
                    html: "<small>The dialog will close soon!!!</small>",
                    icon: "success",
                    allowOutsideClick: false,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false
                });

                let router = this.$router;

                setTimeout(function() {
                    swal.close();

                    router.push({ name: "Todo" });
                }, 1500);
            }
        }
    }
};
</script>

<style></style>
