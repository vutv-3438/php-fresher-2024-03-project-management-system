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
    .sass('resources/sass/app.scss', 'public/css')
    // Pages
    .js('resources/js/pages/workFlows/index.js', 'public/js/pages/workFlows')
    .js('resources/js/pages/workFlows/edit.js', 'public/js/pages/workFlows')
    .js('resources/js/pages/issueTypes/index.js', 'public/js/pages/issueTypes')
    .js('resources/js/pages/issues/index.js', 'public/js/pages/issues')
    .js('resources/js/pages/issues/edit.js', 'public/js/pages/issues')
    .js('resources/js/pages/roles/index.js', 'public/js/pages/roles')
    .js('resources/js/pages/roles/edit.js', 'public/js/pages/roles')
    .js('resources/js/pages/roleClaims/main.js', 'public/js/pages/roleClaims')
    .js('resources/js/pages/members/index.js', 'public/js/pages/members')
    .js('resources/js/pages/users/index.js', 'public/js/pages/users')
    .js('resources/js/pages/report/index.js', 'public/js/pages/report')
    // Quill
    .js('node_modules/quill/dist/quill.js', 'public/js')
    .postCss('node_modules/quill/dist/quill.snow.css', 'public/css')
    .postCss('node_modules/quill/dist/quill.bubble.css', 'public/css')
    // Select2
    .copy('node_modules/select2/dist/css/select2.min.css', 'public/css')
    .copy('node_modules/select2/dist/js/select2.min.js', 'public/js')
    .sourceMaps();
