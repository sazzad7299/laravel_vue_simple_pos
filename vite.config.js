import { defineConfig } from 'vite';
import i18n from 'laravel-vue-i18n/vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: process.env.appUrl,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            ziggyVue: '../../vendor/tightenco/ziggy/dist/vue.m',
            '@': '/resources/js',
        },
    },
});
