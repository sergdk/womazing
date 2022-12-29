let mix = require('laravel-mix');
// let minifier = require('minifier');

mix
    // .sass('assets/src/style.scss', 'assets/css/styles.css')
    .minify('css/style.css')
    .minify('css/page_content.css')
    .minify('css/add.css')
    // .postCss('assets/src/add.css', 'assets/css/add.css')
    //
    .minify('js/checkout.js')
    .minify('js/modal-cart.js')
    .minify('js/page-cart.js')
    .minify('js/script.js')
    .minify('js/slider.js')

// mix.then(() => {
//     minifier.minify('assets/css/styles.css')
// });