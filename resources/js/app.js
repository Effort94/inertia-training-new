// Import
import { createApp, h } from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import '../css/app.css';
import axios from "axios";

// Create an Axios instance
const axiosInstance = axios.create({
    headers: {
        'Content-Type': 'application/json'
    }
    // Add any other custom settings if needed
});

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Attach Axios to the global properties
        app.config.globalProperties.$axios = axiosInstance;

        // Use necessary plugins
        app.use(plugin)
            .mount(el);
    },

    progress: {
        color: '#29d',
        showSpinner: true
    }
});
