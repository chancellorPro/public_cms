<?php

/**
 * Random Pet Names
 */
return [
    'name' => 'Random Pet Names',
    'counter' => 'random_pet_names_counter',
    'fixed_rows' => true,
    'default_structure' => [
        [
            'names' => [
                ['name' => 'Alex'],
                ['name' => 'Mobage'],
                ['name' => 'Dregon'],
                ['name' => 'Donald'],
                ['name' => 'Patrick'],
            ], 'gender' => 1,
        ],
        [
            'names' => [
                ['name' => 'Trixy'],
                ['name' => 'Tiffany'],
                ['name' => 'Walkure'],
                ['name' => 'Leona'],
                ['name' => 'Dasha'],
            ], 'gender' => 2,
        ],
    ],
    'to_config' => true,
    'presets' => [
        'gender' => 'gender',
    ],
    'fields' => [
        'gender' => [
            'create_type' => 'select',
            'list_type' => 'selectView',
            'filter_type' => '',
            'config_type' => 'int',
        ],

        'names' => [
            'table_head_attrs' => 'style="width: 600px"',
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'name' => [
                    'create_type' => 'string',
                    'list_type' => 'string',
                    'filter_type' => 'string',
                ],
            ]
        ]
    ]
];
