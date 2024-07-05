<?php

return [
    'sandbox' => [
        'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
    ],
    'live' => [
        'client_id'     => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
    ],
    'mode'    => env('PAYPAL_MODE', 'sandbox'),
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'locale'         => env('PAYPAL_LOCALE', 'en-US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
    'brand_name'     => env('PAYPAL_BRAND_NAME', '')
];
