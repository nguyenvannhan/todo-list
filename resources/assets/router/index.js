import Vue from "vue";
import Router from "vue-router";

import TheContainer from "../containers/TheContainer.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";

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
