import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/app.scss',
                'resources/app.js',
            ],
            refresh: true,
        }),
    ],
});
