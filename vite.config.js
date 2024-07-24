import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';

const env = loadEnv(process.env.APP_ENV, process.cwd());

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true
        },
        /**
         * configure for multiple running vite port
         * so we can run multiple laravel project with vite
         * */
        port: env.VITE_PORT ? parseInt(env.VITE_PORT) : 5173,
    },
});
