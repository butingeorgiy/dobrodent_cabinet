const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .styles('resources/css/bootstrap.css', 'public/css/app.css');

mix.disableNotifications();
