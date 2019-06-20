<?php

/**
 * Default Pet Appearance config
 */
return [
    'name'    => 'Default Pet Appearance',
    'counter' => 'dpa_counter',
    'fields'  => [
        'id'         => [
            'create_type' => 'autoincrement',
            'list_type'   => 'autoincrement',
            'filter_type' => 'int',
            'validator'   => [
                'required',
                'numeric',
            ],
        ],
        'gender'         => [
            'create_type' => 'int',
            'list_type'   => 'int',
            'filter_type' => 'int',
            'validator'   => [
                'required',
                'numeric',
            ],
        ],
        'body_parts' => [
            'create_type' => 'array',
            'list_type'   => 'array',
            'validator'   => [
                'required',
                'array',
            ],
        ],
    ],
];
