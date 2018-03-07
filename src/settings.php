<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database settings
        'db' => [
            'host' => 'blugcj2oq-mysql.services.clever-cloud.com:3306', // HOTE DE LA BASE
            'dbname' => 'blugcj2oq', // NOM DE LA BASE
            'user' => 'u5jugyyqcysh8kjo', // UTILISATEUR
            'pass' => 'z01CioDzlMf8gYjHnEo' // MOT DE PASSE
        ]
    ],
];
