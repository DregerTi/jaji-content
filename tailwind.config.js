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
    colors: {
      'black': '#222222',
      'white': '#FAFCFE',
      'lightgrey': '#EBEBEB',
      'grey': '#7E7E7E',
      'primary': '#355070',
      'secondary': '#8EC9D1',
      'success': '#458E9D',
      'red': '#E67377',
      'warning': '#FFA630',
    },
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
