import './bootstrap';
import '../css/app.css';
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import 'lightbox2';
import 'lightbox2/dist/js/lightbox.min.js';
import 'vue-toastify/index.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/index.js';
import DataTablesLib from 'datatables.net';
import DataTable from 'datatables.net-vue3';
import Buttons from 'datatables.net-buttons/js/dataTables.buttons.min.js';
import 'datatables.net-select';
import 'datatables.net-buttons/js/buttons.html5.min.js';
import 'datatables.net-buttons/js/buttons.print.min.js';
import 'vue3-toastify/dist/index.css';
// import 'datatables.net-buttons/css/buttons.dataTables.min.css';
// import Toast from 'vue3-toastify';
import Toggle from '@vueform/toggle';
import * as countryStateCity from 'country-state-city';
window.$ = window.jQuery = jQuery;

DataTable.use(DataTablesLib);
const appName = import.meta.env.VITE_APP_NAME || 'Instant Loan';

createInertiaApp({
    // title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(ZiggyVue, Ziggy);
        app.component('DataTable', DataTable);
        app.component('Toggle', Toggle);
        // app.use(Toast,{
        //     autoClose: 200,
        //     position:"top-right",
        //     canTimeout:true,
        //     errorDuration:200,
        //     successDuration:200,
        //     alertInfoDuration:200,
        //     duration:500,
        // });
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
