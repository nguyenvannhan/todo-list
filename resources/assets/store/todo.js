import Vue from "vue";
import Vuex from "vuex";

import axios from "axios";

Vue.use(Vuex);

const state = {
    todoList: []
};

const mutations = {
    SET_TODO_LIST(state, todoList) {
        state.todoList = todoList;
    },

    UPDATE_TODO_ITEM(state, todoItem) {
        let key = state.todoList.data.findIndex(item => {
            console.log(item);
            console.log(todoItem);
            return item.id == todoItem.id;
        });

        console.log(key);

        if (key !== -1) {
            state.todoList.data[key] = todoItem;
        }
    }
};

const actions = {
    async getTodoList({ commit }, { status, page }) {
        let response = await axios.get("/tasks", {
            params: {
                status: status,
                page: page > 1 ? page : 1
            }
        });

        commit("SET_TODO_LIST", response.data);
    },
    async getTodoItem({ commit }, id) {
        let response = await axios.get(`/tasks/${id}`);

        if (response.status === 200) {
            return response.data.data;
        }

        return null;
    },
    async createTodoItem({ commit }, data) {
        try {
            let response = await axios.post("/tasks", data);

            return {
                status: response.status
            };
        } catch (e) {
            if (e.response.status === 422) {
                return {
                    status: e.response.status,
                    messages: e.response.data.errors
                };
            } else {
                return {
                    status: e.response.status
                };
            }
        }
    },
    async updateTodoItem({ commit }, { id, data }) {
        try {
            let response = await axios.patch(`/tasks/${id}`, data);

            return {
                status: response.status
            };
        } catch (e) {
            if (e.response.status === 422) {
                return {
                    status: e.response.status,
                    messages: e.response.data.errors
                };
            } else {
                return {
                    status: e.response.status
                };
            }
        }
    },
    async markComplete({ commit }, { id }) {
        try {
            let response = await axios.patch(`/tasks/mark-complete`, {
                id: id
            });

            return {
                status: response.status
            };
        } catch (e) {
            if (e.response.status === 422) {
                return {
                    status: e.response.status,
                    messages: e.response.data.errors
                };
            } else {
                return {
                    status: e.response.status
                };
            }
        }
    },
    async deleteTodoItem({ commit }, id) {
        let response = await axios.delete(`/tasks/${id}`);

        if (response.data.success) {
            return true;
        }
        return false;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
