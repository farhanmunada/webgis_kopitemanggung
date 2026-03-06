import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                coffee: {
                    50: '#f5f3f1',
                    100: '#e6ded9',
                    200: '#cebbae',
                    300: '#b29380',
                    400: '#9b7159',
                    500: '#845741',
                    600: '#724736',
                    700: '#5c392b',
                    800: '#4d3227',
                    900: '#3f2a22',
                    950: '#1b120f',
                },
                primary: '#E87A38', // Orange highlight
            }
        },
    },

    plugins: [forms],
};
