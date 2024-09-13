<?php

return [
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'locale'         => env('PAYPAL_LOCALE', 'en-US'),
    'default_tax_percent' => env('PAYMENT_DEFAULT_TAX_PERCENT', 15),
];
