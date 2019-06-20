<?php

/**
 * Initial User
 */
return [
    'name' => 'Fcd User Data',
    'counter' => 'initial_user_counter',
    'add_mult_rows' => false,
    'presets' => [
        // fieldname => var name in presets config
        'placement_type' => '\App\Models\Cms\Placement::getRoomTypesList',
        'placement_group' => 'initial_user_placement_groups',

    ],
    'fields' => [
        'coins' => [
            'table_head_class' => 'xs',
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => 'int',
        ],
        'cash' => [
            'table_head_class' => 'xs',
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => 'int',
        ],
        'fcd' => [
            'table_head_class' => 'xs',
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => 'int',
        ],
        'assets' => [
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed_style' => 'table',
            'embed' => [
                'asset_id' => [
                    'create_type' => 'int',
                    'list_type' => 'int',
                    'filter_type' => 'int',
                ],
                'placement_group' => [
                    'create_type' => 'select',
                    'list_type' => 'select',
                    'filter_type' => 'select',
                ],
                'x' => [
                    'create_type' => 'int',
                    'list_type' => 'int',
                    'filter_type' => 'int',
                ],
                'y' => [
                    'create_type' => 'int',
                    'list_type' => 'int',
                    'filter_type' => 'int',
                ]
            ]
        ],
        'placements' => [
            'embed_style' => 'table',
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'placement_type' => [
                    'create_type' => 'select',
                    'list_type' => 'select',
                    'filter_type' => 'select',
                ],
                'count' => [
                    'create_type' => 'int',
                    'list_type' => 'int',
                    'filter_type' => 'int',
                ]
            ]
        ],
    ],
];
