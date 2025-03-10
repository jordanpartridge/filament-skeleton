<?php

declare(strict_types=1);

return [
    'components' => [
        'cache' => [
            'columnSpan' => [
                'default' => 'full',
                'md' => 1,    // Take up half the dashboard width on medium screens
            ],
        ],

        'queues' => [
            'columnSpan' => [
                'default' => 'full',
                'md' => 1,    // Take up half the dashboard width on medium screens
            ],
        ],
        
        // Keep other component configurations from the vendor file
    ],
];
