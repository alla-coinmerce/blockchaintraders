import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/admin.js',
                'resources/js/portal.js',
                'resources/js/web.js'],
            refresh: true,
        }),
    ],
});
