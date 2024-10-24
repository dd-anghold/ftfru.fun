import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    server: {
        port: 5173,
        watch: {
            usePolling: true,
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        outDir: "public/build",
        rollupOptions: {
            output: {
                entryFileNames: "js/[name].[hash].js",
                chunkFileNames: "js/[name].[hash].js",
                assetFileNames: ({ name }) => {
                    if (name.endsWith(".css")) {
                        return "css/[name].[hash][extname]";
                    } else if (/\.(woff2?|eot|ttf|otf)$/.test(name)) {
                        return "font/[name].[hash][extname]";
                    }
                    return "assets/[name].[hash][extname]";
                },
            },
        },
    },
});
