/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/*.php',
    './templates/**/*.php',
    './templates/**/*.html',
  ],
  theme: {
    extend: {
        fontFamily: {
            lato: ['Lato', 'sans-serif'],
        },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

