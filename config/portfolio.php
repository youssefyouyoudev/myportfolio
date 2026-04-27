<?php

return [
    'availability' => [
        'status' => env('PORTFOLIO_AVAILABILITY_STATUS', 'available'),
        'accepting_from' => env('PORTFOLIO_AVAILABILITY_FROM'),
        'typical_duration' => env('PORTFOLIO_TYPICAL_DURATION', '4 to 8 weeks'),
    ],
    'show_client_logos' => env('SHOW_CLIENT_LOGOS', false),
];
