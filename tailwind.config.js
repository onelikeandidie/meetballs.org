/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                mono: ["JetBrains Mono", "sans-serif"],
                sans: ["Inter", "sans-serif"],
            },
        },
    },
    plugins: [],
}

