<?php

/**
 * Room Default Assets
 */
return [
    'name' => 'Room Default Assets',
    'counter' => 'room_default_assets_counter',
    'add_mult_rows' => false,
    'presets' => [
        // fieldname => var name in presets config
        'placement' => '\App\Models\Cms\Placement::getPresetPlacementsList',
        'placement_group' => 'initial_user_placement_groups',

    ],
    'fields' => [
        'placement' => [
            'create_type' => 'select',
            'list_type' => 'selectView',
            'filter_type' => 'select',
            'config_type' => 'int',
        ],

        'assets' => [
            'table_head_attrs' => 'style="width: 300px"',
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'asset_id' => [
                    'create_type' => 'int',
                    'list_type' => 'int',
                    'filter_type' => 'int',
                ],
            ],
        ],
    ],
];
