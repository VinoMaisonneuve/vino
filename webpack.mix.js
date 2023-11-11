const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/bottleCounter.js', 'public/js')
   .js('resources/js/bottleCounterModal.js', 'public/js')
   .js('resources/js/carousel.js', 'public/js')
   .js('resources/js/filterSlider.js', 'public/js')
   .js('resources/js/filterTag.js', 'public/js')
   .js('resources/js/modalAjouter.js', 'public/js')
   .js('resources/js/modalDeplacer.js', 'public/js')
   .js('resources/js/modalSupprimer.js', 'public/js')
   .js('resources/js/queryBottles.js', 'public/js')
   .js('resources/js/sortBottles.js', 'public/js')
   .js('resources/js/search-users.js', 'public/js')
   .js('resources/js/modalAjouterBouteilleIndex.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);