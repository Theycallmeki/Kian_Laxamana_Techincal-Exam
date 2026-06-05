import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import axios from 'axios'

// Configure Axios globally
// Point to the backend URL and make sure cookies are included!
axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true
axios.defaults.headers.common['Accept'] = 'application/json'

const app = createApp(App)

// Make axios available everywhere in Vue using this.$axios
app.config.globalProperties.$axios = axios

app.mount('#app')
