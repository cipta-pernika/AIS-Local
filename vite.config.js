import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

const host = "localhost";

export default defineConfig({
    plugins: [
        laravel({
            input: ["public/frontend/src/index.tsx", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes("node_modules")) {
                        return `vendor-${
                            id
                                .toString()
                                .split("/node_modules/")[1]
                                .split("/")[0]
                        }`;
                    }
                },
            },
        },
        chunkSizeWarningLimit: 5800,
        reportCompressedSize: false,
    },
    server: {
        host,
        hmr: { host },
    },
});
