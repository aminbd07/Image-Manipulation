window.Vue = require("vue");
import VueRouter from "vue-router";
window.axios = require("axios");
window.qs = require("qs");
import { VLazyImagePlugin } from "v-lazy-image";
import Snotify, { SnotifyPosition } from "vue-snotify";
const SnotifyOptions = {
  toast: {
    position: SnotifyPosition.rightTop,
  },
};
Vue.use(VueRouter);
Vue.use(VLazyImagePlugin);
Vue.use(Snotify, SnotifyOptions);
import home from "./views/home.vue";
import edit from "./views/edit.vue";

Vue.component("App", require("./components/layout.vue").default);

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: home,
    },
    {
      path: "/edit/:filename",
      name: "edit",
      component: edit,
    },
  ],
});

const app = new Vue({
  el: "#app",
  router,
});
