<?php

return [
    'pagination' => [
        'number' => env('PAGINATION_NUMBER', 50)
    ],
    'api' => [
        'url' => env('API_BASE_URL', ''),
        'key' => env('API_KEY', '')
    ],
    'plugins' => [
        'directory' => base_path('app/Plugins/'),
        'namespace' => '\\App\\Plugins\\'
    ],
    'skins' => [
        'data_key' => env('SKINS_DATA_KEY', '<[data]>'),
        'directory' => env('SKINS_DIRECTORY', '/skins/'),
        'download_directory' => env('SKINS_DOWNLOAD_DIRECTORY', '/app/downloads/'),
    ]
];
