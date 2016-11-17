const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

// <!-- Bootstrap -->
// <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
//     <!-- Font Awesome -->
// <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
//     <!-- NProgress -->
//     <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
//     <!-- bootstrap-wysiwyg -->
//     <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
//
//     <!-- Custom styling plus plugins -->
// <link href="../build/css/custom.min.css" rel="stylesheet">

elixir(function(mix) {

    mix.styles([
        'bootstrap.min.css',
        'custom.min.css',
        'font-awesome.min.css',
        'nprogress.css',
        'green.css',
        'bootstrap-progressbar-3.3.4.min.css',
        'jqvmap.min.css',
        'prettify.min.css'
    ]);
});

elixir(function(mix) {
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'fastclick.js',
        'nprogress.js',
        'bootstrap-wysiwyg.min.js',
        'jquery.hotkeys.js',
        'prettify.js',
        'custom.min.js'
    ]);
});