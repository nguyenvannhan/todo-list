require("./bootstrap");

import "core-js/stable";
import Vue from "vue";
import App from "../views/Index";
import router from "../router";
import CoreuiVue from "@coreui/vue";
import { iconsSet as icons } from "../admin-core/assets/icons/icons.js";
import store from "../store";
import VueAuth from "@websanova/vue-auth";
import auth from "./auth";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import VueSweetalert2 from "vue-sweetalert2";

import wysiwyg from "vue-wysiwyg";

window.Vue = Vue;

Vue.config.performance = true;
Vue.use(CoreuiVue);
Vue.prototype.$log = console.log.bind(console);

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

Vue.use(VueSweetalert2);

Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
Vue.use(VueAuth, auth);

Vue.use(wysiwyg, {});

new Vue({
    el: "#app",
    store,
    router,
    icons,
    template: "<App/>",
    components: {
        App
    }
});
