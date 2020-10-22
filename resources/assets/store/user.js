import Vue from "vue";
import Vuex from "vuex";

import axios from "axios";

Vue.use(Vuex);

const state = {
    userList: []
};

const mutations = {
    SET_USER_LIST(state, userList) {
        state.userList = userList;
    }
};

const actions = {
    async getUserList({ commit }) {
        let response = await axios.get("/users");

        commit("SET_USER_LIST", response.data.data);
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
