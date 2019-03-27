<?php

return [
    'pagination' => [
        'number' => env('PAGINATION_NUMBER', 50)
    ]
    ,
    'api' => [
        'url' => env('API_BASE_URL', ''),
        'key' => env('API_KEY', '')
    ],

    'plugins' => [
        'directory' => base_path('app/Plugins/'),
        'namespace' => '\\App\\Plugins\\'
    ]
];