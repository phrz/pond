<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // Eloquent settings
        'eloquent' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'pond',
            'username' => 'pond',
            'password' => 'familiar-history-procession-remark',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
        ],

    ],
];
