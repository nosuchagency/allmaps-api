<?php

return [
    'pagination' => [
        'number' => env('PAGINATION_NUMBER', 50)
    ],
    'api' => [
        'url' => env('API_BASE_URL', ''),
        'key' => env('API_KEY', '')
    ]
];