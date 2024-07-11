import 'bootstrap';
import { MaskInput } from 'vue-3-mask';
import VueSweetalert2 from 'vue-sweetalert2';
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { createApp } from 'vue/dist/vue.esm-bundler';
const app = createApp({});

const componentFiles = import.meta.glob('./components/*.vue', { eager: true });

for (const path in componentFiles) {
    const componentName = path.split('/').pop().split('.')[0];
    const componentConfig = componentFiles[path];
    app.component(componentName, componentConfig.default || componentConfig);
}

app.use(VueSweetalert2);
app.config.globalProperties.$http = axios;
app.config.globalProperties.$toast = (title, html, icon) => {
    app.config.globalProperties.$swal.fire({
        icon,
        title,
        html,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', app.config.globalProperties.$swal.stopTimer);
            toast.addEventListener('mouseleave', app.config.globalProperties.$swal.resumeTimer);
        }
    });
}


app.component('MaskInput', MaskInput);
app.mount("main")