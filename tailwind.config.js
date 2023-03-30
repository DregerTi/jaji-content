/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./assets/**/*.js",
    "./templates/**/*.{html,twig}",
    "./templates/components/**/*.{html,twig}",
    "./templates/front/**/*.{html,twig}",
    "./templates/back/**/*.{html,twig}",
    "./src/**/*.{html,js}",
    "./templates/**/*.{html,twig}",
  ],
  theme: {
    extend: {
      fontFamily: {
        'prompt': ['Prompt', 'sans-serif']
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
