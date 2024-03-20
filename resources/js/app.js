import "./bootstrap";
import "vue-select/dist/vue-select.css";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { i18nVue } from "laravel-vue-i18n";
import router from "./router/router";
import mixin from "./mixins/mixin";
import vSelect from "vue-select";
import moment from "moment";
import PermissionsMixin from "./mixins/permissionMixin";
import  companyMixin from "./mixins/companyMixin";
const app = createApp({});
const pinia = createPinia();
app.mixin(mixin);
app.mixin(companyMixin);
app.use(router);
app.use(pinia);
app.use(ZiggyVue);
app.use(i18nVue, {
  lang: localStorage.getItem('lang') ? localStorage.getItem('lang') : 'en',
  resolve: async (lang) => {
    const langs = import.meta.glob("../../lang/*.json");
    return await langs[`../../lang/${lang}.json`]();
  },
});
app.mixin(PermissionsMixin);
app.component("pagination", Bootstrap5Pagination);
app.component("v-select", vSelect);
app.config.globalProperties.$filters = {
  timeAgo(date) {
    return moment(date).fromNow();
  },
  customFormat(date) {
    return moment(date).format("D MMM YYYY");
  },
  MYFormat(date) {
    return moment(date).format("MMMM YYYY");
  },
};
axios.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response.status === 403) {
      router.go(-1);
    }
    return Promise.reject(error);
  }
);
app.mount("#app");
