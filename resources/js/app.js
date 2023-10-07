import { createApp } from "vue/dist/vue.esm-bundler";

import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

import "../css/app.css";

import App from "./App.vue";

const app = createApp({});

app.use(ElementPlus);

app.component("search", App);

app.mount("#app");
