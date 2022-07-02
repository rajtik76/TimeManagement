import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'vite-plugin-laravel'
import autoprefixer = require("autoprefixer")
import tailwindcss from 'tailwindcss'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            postcss: [
                tailwindcss(),
                autoprefixer(),
            ]
        })
    ]
})
