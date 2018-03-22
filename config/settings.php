<?php

return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        'sessionGenerator' => [
            // Now unused
            'lengths' => [
                3600,        // 1 hour
                3600 + 1800, // 1 hour 30 mins
                10800,       // 3 hours
                3600 * 48    // 2 days
            ],
            'padding' => 0,
        ],

        'availabilityGenerator' => [
            'rules' => [
                [
                    'from' => [
                        'dotw' => 'monday',
                        'time' => '10:00',
                    ],
                    'till' => [
                        'dotw' => 'wednesday',
                        'time' => '10:00'
                    ]
                ],
                [
                    'from' => [
                        'dotw' => 'thursday',
                         'time' => '10:00',
                    ],
                    'till' => [
                        'dotw' => 'thursday',
                        'time' => '13:00'
                    ]
                ],
                [
                    'from' => [
                        'dotw' => 'thursday',
                        'time' => '15:00',
                    ],
                    'till' => [
                        'dotw' => 'thursday',
                        'time' => '18:00'
                    ]
                ],
                [
                    'from' => [
                        'dotw' => 'friday',
                        'time' => '12:00',
                    ],
                    'till' => [
                        'dotw' => 'friday',
                        'time' => '18:00'
                    ]
                ]
            ],
        ],

        'priceExpression' => [
            'pricePerHour' => 25.00,
        ],

        'currencies' => [

        ],

        // some mock services
        'services'   => [
            "15" => [
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
                            'formatted' => '$20.00',
                        ],
                    ],
                    [
                        'length' => 3600 + 1800, // 1 hour 30 mins
                        'price'  => [
                            'amount'    => 30,
                            'currency'  => 'USD',
                            'formatted' => '$30.00',
                        ],
                    ],
                    [
                        'length' => 10800,       // 3 hours
                        'price'  => [
                            'amount'    => 50,
                            'currency'  => 'USD',
                            'formatted' => '$50.00',
                        ],
                    ],
                ],
            ],
            "22" => [
                'id'             => 22,
                'title'          => 'Diving lessons',
                'description'    => "Lorem ipsum",
                'imageSrc'       => 'http://loremflickr.com/64/64/diving',
                'sessionLengths' => [
                    [
                        'length' => 7200, // 2 hour
                        'price'  => [
                            'amount'    => 99.99,
                            'currency'  => 'EUR',
                            'formatted' => '€20.00',
                        ],
                    ],
                ],
            ],

        ],
    ],
];
