import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Default from './layout/wrapper/index.vue'
const app = createApp(App)
import Toaster from "@meforma/vue-toaster";


app.use(router)
app.use(Toaster,{
    position: 'top-right',
});
app.component("default-layout", Default);

app.mount("#app")