import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { initFlowbite } from 'flowbite'

import App from './App.vue'
import router from './router'

const app = createApp(App)

initFlowbite()
app.use(createPinia())
app.use(router)

app.mount('#app')
