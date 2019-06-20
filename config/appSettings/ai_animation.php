<?php

use \Illuminate\Validation\Rule;
use \App\Models\Cms\Asset;

/**
 * Ai Animation
 */
return [
    'name' => 'Ai Animation',
    'counter' => 'animation_counter',
    'presets' => [
        // fieldname => var name in presets config
        'type' => 'ai_object_types',
        'state_name' => 'ai_state_types',
    ],

    'fields' => [
        'id' => [
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => 'int',
            'table_head_class' => 'id',
        ],
        'type' => [
            'create_type' => 'select',
            'list_type' => 'select',
            'filter_type' => 'select',
        ],
        'animation_data' => [
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'state_name' => [
                    'create_type' => 'select',
                    'list_type' => 'select',
                    'filter_type' => 'select',
                ],
                'clips_in_state' => [
                    'create_type' => 'embed',
                    'list_type' => 'embed',
                    'filter_type' => 'embed',
                    'embed_style' => 'table',
                    'embed' => [
                        'anim_id' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ],
                        'speed' => [
                            'create_type' => 'float',
                            'list_type' => 'float',
                            'filter_type' => 'float',
                        ],
                        'weight' => [
                            'create_type' => 'float',
                            'list_type' => 'float',
                            'filter_type' => 'float',
                        ],
                        'anim_clip_name' => [
                            'create_type' => 'string',
                            'list_type' => 'string',
                            'filter_type' => 'string',
                        ],
                        'linked_object_id' => [
                            'create_type' => '',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                            'validator' => [
                                'nullable',
                                'numeric',
                                Rule::exists('assets', 'id')->where(function ($query) {
                                    $query->where('type', Asset::ASSET_TYPE_LINKED);
                                }),
                            ],
                        ],
                        'is_breakable' => [
                            'create_type' => 'bool',
                            'list_type' => 'bool',
                            'filter_type' => 'bool',
                        ],
                        'is_eyes_free' => [
                            'create_type' => 'bool',
                            'list_type' => 'bool',
                            'filter_type' => 'bool',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
