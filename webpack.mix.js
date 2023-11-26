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

mix.styles([
    'public/css/admin.css',
    'public/css/btn.css',
    'public/css/card.css',
    'public/css/carousel.css',
    'public/css/composition.css',
    'public/css/fiche.css',
    'public/css/footer.css',
    'public/css/form.css',
    'public/css/general.css',
    'public/css/info.css',
    'public/css/link.css',
    'public/css/modal.css',
    'public/css/nav.css',
    'public/css/pagination.css',
    'public/css/styles.css',
    'public/css/tag.css',
    'public/css/toast.css',
    'public/css/typography.css',
    'public/css/variables.css',
    'public/css/welcome.css',
], 'public/css/all.css');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/bottleCounter.js', 'public/js')
   .js('resources/js/bottleCounterModal.js', 'public/js')
   .js('resources/js/carousel.js', 'public/js')
   .js('resources/js/filterSlider.js', 'public/js')
   .js('resources/js/filterTag.js', 'public/js')
   .js('resources/js/modalAjouter.js', 'public/js')
   .js('resources/js/modalAjouterBouteilleIndex.js', 'public/js')
   .js('resources/js/modalDeplacer.js', 'public/js')
   .js('resources/js/modalSupprimer.js', 'public/js')
   .js('resources/js/queryBottles.js', 'public/js')
   .js('resources/js/search-cellar.js', 'public/js')
   .js('resources/js/search-users.js', 'public/js')
   .js('resources/js/sortBottles.js', 'public/js')
   .js('resources/js/statsUser.js', 'public/js')
   .js('resources/js/textCercle.js', 'public/js')
   .js('resources/js/showToast.js', 'public/js')
   .js('resources/js/zoom.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);