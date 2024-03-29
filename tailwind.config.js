const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                popins: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#A349A3",
                transaksi: "#F6F8FD",
            },

            backgroundImage: {
                "hero-pattern": "url('/gambar/bg-hero.png')",
            },
            borderRadius: {
                "56px": "56px",
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("tw-elements/dist/plugin"),
        require("@tailwindcss/typography"),
        require("flowbite/plugin"),
    ],
};
