import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        // Contoh: Mengubah direktori output ke 'public/dist'
        outDir: 'build', 
        
        // Contoh lain: Jika Anda ingin output di root direktori proyek (JARANG DIGUNAKAN)
        // outDir: 'dist', 
    },
    server: {
        cors: true,
    },
});