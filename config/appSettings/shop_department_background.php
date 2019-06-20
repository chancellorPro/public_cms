<?php

/**
 * Default assets for Shop Admin
 */
return [
    'name' => 'Shop Department background',
    'counter' => 'shop_department_background_counter',
    'fixed_rows' => true,
    'deploy_files' => [
        'background'
    ],
    'default_structure' => [
        [
            'background' => '',
        ],
    ],
    'fields' => [
        'background' => [
            'create_type' => 'dropzone',
            'list_type' => 'dropzone',
            'filter_type' => null,
        ]
    ]
];