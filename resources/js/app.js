import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import UI from "@indielayer/ui";
import { colors } from "@indielayer/ui";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName = "Jobdeck";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(UI, {
        prefix: "X",
        theme: {
          colors: {
            primary: colors.teal,
            secondary: colors.slate,
            success: colors.green,
            warning: colors.yellow,
            error: colors.red,
            danger: colors.rose,
          },
        },
      })
      .mount(el);
  },
  progress: {
    color: "#4B5563",
  },
});
