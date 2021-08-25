const mix = require('laravel-mix');
let productionSourceMaps = false;

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

mix.js(['resources/js/script.js'], 'public/js')
    .js('resources/vendor/js/vendor.js','public/vendor/js')
    .version();

mix.sass('resources/vendor/css/simplelightbox.scss', 'public/vendor/css/vendor.css')
    .sass('resources/css/style.scss', 'public/css/app.css')
    .options({
        processCssUrls: false
    })
    .version();
if (!mix.inProduction()) {
    // mix.sourceMaps(productionSourceMaps, 'source-map');
}
