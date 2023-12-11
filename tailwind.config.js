import defaultTheme from "tailwindcss/defaultTheme";
const colors = require("tailwindcss/colors");
const indielayer = require("@indielayer/ui/tailwind.preset");
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
    "node_modules/@indielayer/ui/{lib,src}/**/*",
  ],
  presets: [indielayer()],
  theme: {
    extend: {
      fontFamily: {
        // sans: ["Figtree", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: colors.emerald,
        secondary: colors.slate,
        success: colors.green,
        warning: colors.yellow,
        error: colors.red,
      },
    },
  },

  plugins: [],
};
