<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. Adjust these settings as needed for your app.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // ✅ include sanctum cookie route

    'allowed_methods' => ['*'], // ✅ Allow all HTTP methods (GET, POST, PUT, DELETE)

    'allowed_origins' => ['http://localhost:3000'], // ✅ React frontend URL

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // ✅ Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // ✅ important for Sanctum auth (cookies & sessions)
];
