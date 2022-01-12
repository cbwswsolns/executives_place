<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Exchange Rate Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default exchange rate "driver"
    |
    | Supported: "local", "api"
    |
    */

    'driver' => env('EXCHANGE_RATE_DRIVER', 'local'),

    'api_key' => env('FREE_CURRENCY_API_KEY'),
    
    'allowed_currencies' => ['EUR', 'USD', 'GBP'],
];
