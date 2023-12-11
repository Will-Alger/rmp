import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "background-primary": "#161619",
                "background-secondary": "#25262C",
                "accent-primary": "#39C298",
                "accent-secondary": "#F80053",

                "electric-violet": "#3B37E5",
                "gumball-pink": "#E6378B",
            },
        },
    },

    plugins: [forms],
};
