import { createApp } from 'vue';
import { createPinia } from 'pinia';
import VueApexCharts from 'vue3-apexcharts';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import App from './App.vue';
import router from './router';

// CSS imports
import './assets/css/satoshi.css';
import './assets/css/style.css';
import 'jsvectormap/dist/css/jsvectormap.min.css';
import 'flatpickr/dist/flatpickr.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

const app = createApp(App);

// Using plugins with the Vue 3 application instance
app.use(createPinia());
app.use(router);
app.use(ToastPlugin);
app.use(VueApexCharts);

app.mount('#app');