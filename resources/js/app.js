import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import All from './Layouts/All.vue';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

import { store } from "./store"

import { useStore } from 'vuex'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || All
    return page
  },
  setup({ el, App, props, plugin }) {



    createApp({
        render: () => h(App, props),
        setup() {
            // const store = useStore()
            // store.dispatch('initialSetings')
        }
    })

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
        .use(ConfirmationService)
        .use(store)
        .mount(el)
  },
})
