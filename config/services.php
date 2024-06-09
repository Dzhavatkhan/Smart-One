<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'yandex' => [
        'client_id' => "6f76063291ab498c9042a5cf1249fa24",
        'client_secret' => "60dc5848ee2f40ad82251427c47a4761",
        'redirect' => "http://89.111.155.210/api/auth/yandex/callback"
      ],
    'google' => [
        'client_id' => "201230619040-bgjrehc87gl6atvd9q8kj8mpj44on8h0.apps.googleusercontent.com",
        'client_secret' => "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",
        'redirect' => "http://89.111.155.210/api/auth/google/callback"
       ],

];
