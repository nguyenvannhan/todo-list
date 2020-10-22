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
    async updateTodoItem({ commit }, { id, data }) {
        let response = await axios.patch(`/tasks/${id}`, data);

        if (response.status === 200) {
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