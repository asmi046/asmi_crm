import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import {PrimeVueResolver} from '@primevue/auto-import-resolver';

export default defineConfig({
    plugins: [
        vue(),
        Components({
            resolvers: [
              PrimeVueResolver()
            ]
        }),
        laravel({
            input: [
                'resources/js/app.js',
                'public/scss/main.scss',
            ],
            refresh: true,
        }),
    ],
});
