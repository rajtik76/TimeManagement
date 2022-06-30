import { createApp} from "vue/dist/vue.esm-bundler";
import HelloWorld from './components/Welcome.vue';

const app = createApp({});

app.component('hello-world', HelloWorld);

app.mount('#app');
