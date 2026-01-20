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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                brand: '#3b82f6', // or your brand color
                heading: '#1f2937',
                'neutral-secondary-soft': '#f3f4f6',
                'fg-disabled': '#9ca3af',
            },
            borderRadius: {
                'base': '0.5rem',
            }
        },
    },

    plugins: [forms],
};
