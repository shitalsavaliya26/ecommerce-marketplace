<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'encryption' => [
        'type' => env("ENC_TYPE","AES-128-ECB"),
        'secret' => env("ENC_SECRET","4pU3$(`v&[l!`V`y"),
    ],
    'CART_WEIGHT_DEVISION' => env('CART_WEIGHT_DEVISION'),
    'IPAY_MERCHANT_CODE' => env('IPAY_MERCHANT_CODE'),
    'IPAY_MERCHANT_KEY'  => env('IPAY_MERCHANT_KEY'),
    'MERCHANT_PORTAL'  => env('MERCHANT_PORTAL')

];
