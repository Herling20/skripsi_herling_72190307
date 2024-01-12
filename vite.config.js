import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //--- CSS ---//
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/css/cardMahasiswa.css',
                'resources/css/mainHome.css',
                'resources/css/mainMilestoneDosen.css',
                'resources/css/material-dashboard.css',
                'resources/css/sidebar.css',
                'resources/css/table.css',


                //--- JS ---//
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/circular.js',
                'resources/js/sidebar.js',
            ],
            refresh: true,
        }),
    ],
});
