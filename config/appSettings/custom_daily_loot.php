<?php

/**
 * Daily Loot config
 */
return [
    'name'    => 'Daily Loot',
    'counter' => 'daily_loot_counter',
    'presets' => [
        'date' => 'week_days',
    ],
    'fields'  => [
        'id'        => [
            'id'          => 'id',
            'create_type' => 'int',
            'list_type'   => 'hidden',
            'filter_type' => 'hidden',
            'validator'   => [
                'required',
                'numeric',
            ],
        ],
        'date'      => [
            'alias'       => 'd',
            'create_type' => 'datepicker',
            'list_type'   => 'datepicker',
            'filter_type' => 'datepicker',
            'validator'   => [
                'required',
                'string',
            ],
        ],
        'embed_box' => [
            'table_head_attrs' => 'style="width: 450px"',
            'create_type'      => 'embed',
            'list_type'        => 'embed',
            'filter_type'      => 'embed',
            'embed'            => [
                'asset_id' => [
                    'alias'       => 'aid',
                    'create_type' => 'int',
                    'list_type'   => 'asset_preview',
                    'filter_type' => 'int',
                    'validator'   => [
                        'required',
                        'exists:assets,id',
                    ],
                ],
                'x'        => [
                    'alias'       => 'x',
                    'create_type' => 'int',
                    'list_type'   => 'int',
                    'filter_type' => 'int',
                    'validator'   => [
                        'required',
                        'int',
                    ],
                ],
                'y'        => [
                    'alias'       => 'y',
                    'create_type' => 'int',
                    'list_type'   => 'int',
                    'filter_type' => 'int',
                    'validator'   => [
                        'required',
                        'int',
                    ],
                ],
            ]
        ],
    ],
];
