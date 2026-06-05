import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import 'primeicons/primeicons.css';
import axios from 'axios'
import PrimeVue from '@primevue/core/config';
import Aura from '@primeuix/themes/aura';

// Configure Axios globally
// Point to the backend URL and make sure cookies are included!
axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true
axios.defaults.headers.common['Accept'] = 'application/json'

const app = createApp(App)

app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

// Make axios available everywhere in Vue using this.$axios
app.config.globalProperties.$axios = axios

app.mount('#app')
