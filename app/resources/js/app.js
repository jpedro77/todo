require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { SetupCalendar, Calendar, DatePicker } from 'v-calendar';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.$ = window.jQuery = require('jquery');
require('jquery-ui/ui/widgets/datepicker.js')
require('jquery-ui/ui/widgets/slider.js')
require('jquery-ui-timepicker-addon')
import 'jquery-ui/themes/base/datepicker.css'
import 'jquery-ui/themes/base/slider.css'
import 'jquery-ui/themes/base/theme.css'
import 'jquery-ui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.css'

library.add(fas)

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(SetupCalendar, {})
    .use(VueSweetalert2)
    .component('font-awesome-icon', FontAwesomeIcon)
    .component('Calendar', Calendar)
    .component('DatePicker', DatePicker)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
