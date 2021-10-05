const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/piezas/index.js', 'public/js/piezas/')
    .js('resources/js/piezas/create.js', 'public/js/piezas/')
    .js('resources/js/piezas/terceros.js', 'public/js/piezas/')
    .js('resources/js/campanias/create.js', 'public/js/campanias/')
    .js('resources/js/campanias/success.js', 'public/js/campanias/')
    .js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/piezas/index.scss', 'public/css/piezas')
    .sass('resources/sass/layouts/myapp.scss', 'public/css/layouts')
    .sass('resources/sass/layouts/footer.scss', 'public/css/layouts')
    .sass('resources/sass/layouts/headermain.scss', 'public/css/layouts')
    .sass('resources/sass/layouts/header.scss', 'public/css/layouts')
    .sass('resources/sass/home/cuix.scss', 'public/css/home')