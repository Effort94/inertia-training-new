// Import
import { createApp, h } from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import '../css/app.css';

// Primevue
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css'
import 'primevue/resources/primevue.min.css'


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue)
            .mount(el)
    },

    progress: {
        color: '#29d',
        showSpinner: true
    }
});
