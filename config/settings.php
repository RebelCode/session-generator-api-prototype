<?php

return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer'               => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger'                 => [
            'name'  => 'slim-app',
            'path'  => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'sessionGenerator' => [
            'lengths' => [
                3600,        // 1 hour
                3600 + 1800, // 1 hour 30 mins
                10800,       // 3 hours
            ],
            'padding' => 0,
        ],

        'availabilityGenerator' => [
            'rules' => [
                'monday'    => [
                    ['10:00', '17:00'],
                ],
                'tuesday'   => [
                    ['10:00', '17:00'],
                ],
                'wednesday' => [
                    ['10:00', '12:00'],
                    ['15:00', '19:00'],
                ],
                'thursday'  => [
                    ['10:00', '17:00'],
                ],
                'friday'    => [
                    ['10:00', '17:00'],
                ],
                'saturday'  => [],
                'sunday'    => [],
            ],
        ],

        'priceExpression' => [
            'pricePerHour' => 25.00,
        ],

        'currencies' => [

        ],

        // some mock services
        'services' => [
            15 => [
                'id'             => 15,
                'title'          => 'Polish and clean',
                'description'    => "Lorem ipsum",
                'imageSrc'       => 'http://lorempixel.com/64/64/technics/2/',
                'sessionLengths' => [
                    [
                        'length' => 3600, // 1 hour
                        'price'  => [
                            'amount'    => 20,
                            'currency'  => 'USD',
                            'formatted' => '$20.00'
                        ],
                    ],
                    [
                        'length' => 3600 + 1800, // 1 hour 30 mins
                        'price'  => [
                            'price'  => [
                                'amount'    => 30,
                                'currency'  => 'USD',
                                'formatted' => '$30.00'
                            ],
                        ],
                    ],
                    [
                        'length' => 10800,       // 3 hours
                        'price'  => [
                            'amount'    => 50,
                            'currency'  => 'USD',
                            'formatted' => '$50.00'
                        ],
                    ],
                ],
            ],
            22 => [
                'id'             => 22,
                'title'          => 'Diving lessons',
                'description'    => "Lorem ipsum",
                'imageSrc'       => 'http://loremflickr.com/64/64/diving',
                'sessionLengths' => [
                    [
                        'length' => 7200, // 2 hour
                        'price'  => [
                            'price'  => [
                                'amount'    => 99.99,
                                'currency'  => 'EUR',
                                'formatted' => '€20.00'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
