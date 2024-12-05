// webpack.mix.js
const mix = require('laravel-mix');

mix.js('resources/js/main.jsx', 'public/js')
   .react()
   .sass('resources/sass/app.scss', 'public/css')
   .postCss('resources/css/tamagochi.css', 'public/css', [
       require('tailwindcss'),
   ])
   .version();
