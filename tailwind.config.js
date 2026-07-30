import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // 'class' (not the default 'media') so components carrying leftover Tailwind
    // dark: classes don't flip styling based on the visitor's OS color scheme —
    // this app has no dark-mode toggle, so dark: should never activate on its own.
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#0066cc',
                    light: '#3399ff',
                    dark: '#004c99',
                },
                accent: {
                    DEFAULT: '#00d4aa',
                    dark: '#00a080',
                },
                ink: {
                    DEFAULT: '#0f1419',
                    light: '#1a1f2e',
                },
            },
            boxShadow: {
                soft: '0 10px 40px rgba(0, 0, 0, 0.1)',
                'soft-lg': '0 20px 60px rgba(0, 0, 0, 0.15)',
            },
        },
    },

    plugins: [forms],
};
