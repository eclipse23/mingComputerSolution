const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    purge: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            height: {
              102: '30rem',
              114: '38rem',
              116: '40rem',
            },
            gridTemplateRows: {
                // Simple 8 row grid
               '8': 'repeat(8, minmax(0, 1fr))',
      
                // Complex site-specific row configuration
               'layout': '200px minmax(900px, 1fr) 100px',
            },
            width: {
                '9.5/12': '79.333333%',
                '9.7/12': '82.333333%',
                '10.7/12': '89.333333%'
            }
        },
    },
    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
