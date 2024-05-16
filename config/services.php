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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'o2omeet' => [
        'client_id' =>  env('O2O_MEET_CLIENT_ID'),
        'client_secret' => env('O2O_MEET_CLIENT_SECRET'),
        'master_account' => env('O2O_MEET_MASTER_ACCOUNT')
    ],
    'agora' => [
        'app_id' => env('AGORA_APP_ID'),
        'app_certificate' => env('AGORA_APP_CERTIFICATE'),
    ],
    'twilio' => [
        'username' => env('TWILIO_USERNAME'),
        'password' => env('TWILIO_PASSWORD'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'from' => env('TWILIO_FROM'),
    ],
    'google' => [
        'api_key' => env('GOOGLE_API_KEY'),
    ],

    'rudderstack' => [
        'key' => env('RUDDERSTACK_WRITE_KEY'), 
        'url' => env('RUDDERSTACK_DATA_PLANE_URL'), 
    ],
];
