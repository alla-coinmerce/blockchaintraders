<?php

use Illuminate\Support\Facades\Facade;

return [
    /*
    |--------------------------------------------------------------------------
    | Deribit Client Id
    |--------------------------------------------------------------------------
    |
    | This value is the client id for authenticating with the deribit API.
    |
    */

    'client_id' => env('DERIBIT_CLIENT_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Deribit Client secret
    |--------------------------------------------------------------------------
    |
    | This value is the client secret for authenticating with the deribit API.
    |
    */

    'client_secret' => env('DERIBIT_CLIENT_SECRET', null),
];