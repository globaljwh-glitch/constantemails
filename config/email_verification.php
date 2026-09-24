<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMTP Verification
    |--------------------------------------------------------------------------
    */

    'enabled' => env('EMAIL_VERIFICATION_ENABLED', true),

    /*
    | The address used in MAIL FROM during SMTP verification.
    |
    | This should be an address on your own domain.
    */

    'from' => env(
        'EMAIL_VERIFICATION_FROM',
        'verify@yourdomain.com'
    ),

    /*
    | Your server hostname used for EHLO.
    */

    'helo' => env(
        'EMAIL_VERIFICATION_HELO',
        'yourdomain.com'
    ),

    /*
    | SMTP connection timeout.
    */

    'timeout' => (int) env(
        'EMAIL_VERIFICATION_TIMEOUT',
        10
    ),

    /*
    | Maximum number of MX hosts to try.
    */

    'max_mx_hosts' => (int) env(
        'EMAIL_VERIFICATION_MAX_MX_HOSTS',
        3
    ),

    /*
    | How long a verification result remains cached.
    | 7 days = 10080 minutes.
    */

    'cache_minutes' => (int) env(
        'EMAIL_VERIFICATION_CACHE_MINUTES',
        10080
    ),

    /*
    | Don't verify the same domain too aggressively.
    */

    'delay_microseconds' => (int) env(
        'EMAIL_VERIFICATION_DELAY',
        250000
    ),
];