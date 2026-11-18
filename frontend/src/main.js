import { createApp } from 'vue'
import App from './App.vue'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import {createPinia} from "pinia";
import router from "@/plugins/router.js"
import './main.css'
import i18n from "@/i18n/i18n.js";

createApp(App)
    .use(i18n)
    .use(createPinia())
    .use(router)
    .mount('#app')
