import './bootstrap';

import { createApp } from 'vue';
import app from './app.vue';
import router from './Routes';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import 'primeicons/primeicons.css'


const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
const App = createApp(app);

App.use(pinia)
    .use(router)
    .mount('#app');
