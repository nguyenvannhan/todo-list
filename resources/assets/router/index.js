import Vue from "vue";
import Router from "vue-router";

import TheContainer from "../containers/TheContainer.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import TaskEdit from "../components/TaskEdit.vue";
import TaskDetail from "../components/TaskDetail.vue";
import TaskNew from "../components/TaskNew.vue";

Vue.use(Router);

export default new Router({
    mode: "history", // https://router.vuejs.org/api/#mode
    linkActiveClass: "active",
    scrollBehavior: () => ({ y: 0 }),
    routes: configRoutes()
});

function configRoutes() {
    return [
        {
            path: "/login",
            name: "Login",
            component: Login,
            meta: {
                auth: undefined
            }
        },
        {
            path: "/tasks",
            component: TheContainer,
            children: [
                {
                    path: "edit/:id",
                    name: "TaskEdit",
                    component: TaskEdit
                },
                {
                    path: "new",
                    name: "TaskNew",
                    component: TaskNew
                },
                {
                    path: ":id",
                    name: "TaskDetail",
                    component: TaskDetail
                }
            ]
        },

        {
            path: "/",
            name: "Home",
            redirect: "/",
            component: TheContainer,
            meta: {
                auth: true
            },
            children: [
                {
                    path: ":status?",
                    name: "Todo",
                    component: Dashboard
                }
            ]
        }
    ];
}
