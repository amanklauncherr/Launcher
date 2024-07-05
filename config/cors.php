<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET','POST','PUT','DELETE','OPTIONS'],

    'allowed_origins' => ['*'],
        
        // 'http://127.0.0.1:8000','https://userlauncherr.netlify.app/','https://launcherr-admins.netlify.app','admin.launcherr.co','https://launcherr.co'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
    'Content-Type: application/json',
    'Content-Type: application/x-www-form-urlencoded',
    'Content-Type: multipart/form-data',
    'Authorization:Bearer <token>',
    // 'X-Requested-With',
    'Accept: application/json',
    // 'Origin',
    // 'X-CSRF-TOKEN',
    // 'X-XSRF-TOKEN',
    // 'Accept-Language'
],


    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
