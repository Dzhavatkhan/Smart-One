import './bootstrap';

import { createApp} from 'vue';

import App from "./App.vue"
import router from "./router/index"
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

// import styles bundle
import 'swiper/css/bundle';

// init Swiper:
const swiper = new Swiper();

let app = createApp(App).use(router).use(swiper).use(pinia).mount("#app")

