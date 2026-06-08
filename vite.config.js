import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // 1. Import plugin Tailwind v4

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/kasir.js',],
            refresh: true,
        }),
        tailwindcss(), // 2. Daftarkan di dalam array plugins
    ],
});
