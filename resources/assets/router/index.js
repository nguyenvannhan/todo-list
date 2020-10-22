import Vue from "vue";
import Router from "vue-router";

import TheContainer from "../containers/TheContainer.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import TaskEdit from "../components/TaskEdit.vue";
import TaskDetail from "../components/TaskDetail.vue";
import TaskNew from "../components/TaskNew.vue";
import Page403 from "../views/Page403.vue";
import Page404 from "../views/Page404.vue";

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
                    component: TaskEdit,
                    meta: {
                        auth: {
                            roles: 1,
                            redirect: { name: "login" },
                            forbiddenRedirect: "/403"
                        }
                    }
                },
                {
                    path: "new",
                    name: "TaskNew",
                    component: TaskNew,
                    meta: {
                        auth: {
                            roles: 1,
                            redirect: { name: "login" },
                            forbiddenRedirect: "/403"
                        }
                    }
                },
                {
                    path: ":id",
                    name: "TaskDetail",
                    component: TaskDetail,
                    meta: {
                        auth: true
                    }
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
                    path: "/403",
                    name: "403",
                    component: Page403
                },
                {
                    path: "/404",
                    name: "404",
                    component: Page404
                },
                {
                    path: ":status?",
                    name: "Todo",
                    component: Dashboard
                },
                {
                    path: "*",
                    component: Page404
                }
            ]
        }
    ];
}
