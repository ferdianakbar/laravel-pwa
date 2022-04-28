const mix = require('laravel-mix');
require('laravel-mix-workbox');
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

const workboxCfg = {
    swSrc: './resources/js/sw.js'
}

if(!mix.inProduction()) {
    workboxCfg.maximumFileSizeToCacheInBytes = 10 * 1024 * 1024
}

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css').options({
        processCssUrls: false
    })
    .injectManifest(workboxCfg)
    .sourceMaps();
