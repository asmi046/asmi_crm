import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import All from './Layouts/All.vue';
import ToastService from 'primevue/toastservice';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || All
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })

        .use(plugin)
        .mixin({methods:{route: window.route}})
        .use(PrimeVue, {
            theme: {
                preset: Aura,
                options: {
                    prefix: 'p',
                    darkModeSelector: 'system',
                    cssLayer: {
                        name: 'primevue'
                    }
                }

            }
        })
        .use(ToastService)
        .mount(el)
  },
})
