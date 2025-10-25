import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/animate.css",
                "resources/css/bootstrap.css",
                "resources/css/flexslider.css",
                "resources/css/icomoon.css",
                "resources/css/style.css",
                "resources/js/app.js",
                "resources/js/bootstrap.js",
            ],
            refresh: true,
        }),
    ],
});
