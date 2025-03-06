import defaultTheme from 'tailwindcss/defaultTheme';

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
            colors: {
                'primary': '#f0e000',
                'secondary': '#2E3760',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                black: ['Figtree-Black', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        function ({ addUtilities}) {
            addUtilities({
              '.hide-scrollbar': {
                'scrollbar-width': 'none', 
                '-ms-overflow-style': 'none', 
              },
              '.hide-scrollbar::-webkit-scrollbar': {
                display: 'none',
              },
            })
          }
    ],
};
