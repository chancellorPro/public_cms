<?php

/**
 * AI Behaviour
 */
return [
    'name' => 'ai',
    'counter' => 'ai_counter',
    'presets' => [
        // fieldname => var name in presets config
        'type' => 'ai_object_types',
        'state_type' => 'ai_behaviour_state_types',
        'conditions_type' => 'ai_condition_types',
    ],
    'fields' => [
        'id' => [
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => 'int',
        ],
        'type' => [
            'create_type' => 'select',
            'list_type' => 'select',
            'filter_type' => 'select',
        ],
        'conditions' => [
            'table_head_attrs' => 'style="width: 450px"',
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'conditions_type' => [
                    'create_type' => 'select',
                    'list_type' => 'select',
                    'filter_type' => 'select',
                ],
                'stateDependencies' => [
                    'create_type' => 'embed',
                    'list_type' => 'embed',
                    'filter_type' => 'embed',
                    'embed' => [
                        'state_type' => [
                            'create_type' => 'select',
                            'list_type' => 'select',
                            'filter_type' => 'select',
                        ],
                        'chance' => [
                            'create_type' => 'float',
                            'list_type' => 'float',
                            'filter_type' => 'float',
                        ]
                    ]
                ],
            ]
        ],
        'vital_indications' => [
            'table_head_attrs' => 'style="width: 750px"',
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'stamina' => [
                    'create_type' => 'embed',
                    'list_type' => 'embed',
                    'filter_type' => 'embed',
                    'create_row' => true,
                    'single_row' => true,
                    'embed' => [
                        'max_value' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ],
                        'spend' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ]
                    ]
                ],
                'fun' => [
                    'create_type' => 'embed',
                    'list_type' => 'embed',
                    'filter_type' => 'embed',
                    'create_row' => true,
                    'single_row' => true,
                    'embed' => [
                        'max_value' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ],
                        'spend' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ]
                    ]
                ],
                'satiety' => [
                    'create_type' => 'embed',
                    'list_type' => 'embed',
                    'filter_type' => 'embed',
                    'create_row' => true,
                    'single_row' => true,
                    'embed' => [
                        'max_value' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ],
                        'spend' => [
                            'create_type' => 'int',
                            'list_type' => 'int',
                            'filter_type' => 'int',
                        ]
                    ]
                ],
            ]
        ],
    ]
];
