<?php

/**
 * Levels config
 */
return [
    'name'    => 'Levels',
    'counter' => 'levels_counter',
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
        'name'       => [
            'alias'       => 'n',
            'create_type' => 'string',
            'list_type'   => 'string',
            'filter_type' => 'string',
            'validator'   => [
                'required',
                'string',
            ],
        ],
        'experience' => [
            'alias'       => 'e',
            'create_type' => 'int',
            'list_type'   => 'int',
            'filter_type' => 'int',
            'validator'   => [
                'required',
                'numeric',
            ],
        ],
        'awardId'    => [
            'alias'       => 'aid',
            'create_type' => 'nullableint',
            'list_type'   => 'award',
            'filter_type' => 'int',
            'validator'   => [
                'nullable',
                'numeric',
                'exists:awards,id',
            ],
        ],
    ],
];
