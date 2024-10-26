import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faUserSecret } from "@fortawesome/free-solid-svg-icons";

import NProgress from "nprogress";
import { InertiaProgress } from "@inertiajs/progress";
import "nprogress/nprogress.css";

const appName = import.meta.env.VITE_APP_NAME || "Guitar World";

// Initialize Inertia progress with NProgress
InertiaProgress.init({
    color: "#4B5563",
    showSpinner: true,
});

// Function to determine if the user is on a mobile device
function isMobileDevice() {
    return window.innerWidth < 768;
}

const mobilePages = import.meta.glob("./Pages/mobile/**/*.vue");
const desktopPages = import.meta.glob("./Pages/desktop/**/*.vue");

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./vue/Pages/**/*.vue");
        return resolvePageComponent(`./vue/Pages/${name}.vue`, pages);
    },
    setup({ el, App, props, plugin }) {
        const mainEl = document.querySelector(".app");

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            // .component("font-awesome-icon", FontAwesomeIcon)
            .use(ZiggyVue)
            .mount(mainEl);

        // Event listeners for Inertia navigation to control NProgress
        document.addEventListener("inertia:start", () => {
            NProgress.start();
        });
        document.addEventListener("inertia:finish", (event) => {
            if (
                event.detail.visit.completed ||
                event.detail.visit.interrupted ||
                event.detail.visit.cancelled
            ) {
                NProgress.done();
            }
        });
    },
    progress: {
        color: "#4B5563",
    },
});
