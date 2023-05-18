import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: "public/frontend/src/index.tsx",
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
            optimization: {
                splitChunks: {
                    cacheGroups: {
                        vendor: {
                            test: /[\\/]node_modules[\\/]/,
                            name: "vendor",
                            chunks: "all",
                            enforce: true,
                        },
                    },
                },
            },
        },
        chunkSizeWarningLimit: 5800,
        reportCompressedSize: false,
    },
});
