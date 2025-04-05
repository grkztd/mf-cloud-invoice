<?php

declare(strict_types=1);

return [
    'invoice' => [
        'client_id' => env('MF_CLIENT_ID'),
        'client_secret' => env('MF_CLIENT_SECRET'),
        'redirect_uri' => env('MF_REDIRECT_URI', env('APP_URL') . '/oauth/callback'),
    ]
];
