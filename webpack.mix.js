const mix = require('laravel-mix');

// ##############################################
// // pre rendering for seo -- non va :( ########
// ##############################################

// var HtmlWebpackPlugin = require('html-webpack-plugin');
// var PrerenderSpaPlugin = require('prerender-spa-plugin');


// module.exports.plugins.push(
//     new HtmlWebpackPlugin({
//         template: Mix.Paths.root('resources/views/index.html'),
//         inject: false
//     })
// )

// module.exports.plugins.push(
//     new PrerenderSpaPlugin(
//         Mix.output().path,
//         ['/']
//     )
// );
// ##############################################
// ##############################################



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
    .sass('resources/sass/app.scss', 'public/css')
    // questo non ricompila gli url, dovrebbe velocizzare, ma attento che poi non carica le icone
    // .options({
    //     processCssUrls: false
    // });
