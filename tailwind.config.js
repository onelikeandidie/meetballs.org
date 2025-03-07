import defaultTheme from 'tailwindcss/defaultTheme';
import plugin from "tailwindcss/plugin";
import flattenColorPalette from "tailwindcss/lib/util/flattenColorPalette";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Shrikhand', 'cursive'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        // Plugin to add grid dots of any colour
        // This will be for colour
        plugin(({ matchUtilities, theme }) => {
            matchUtilities(
                {
                    "bg-dots": (value) => ({
                        backgroundImage: `radial-gradient(${value} 1px, transparent 1px)`,
                    }),
                },
                {
                    values: flattenColorPalette(theme('colors')),
                    type: 'color',
                }
            );
        }),
    ],
};
