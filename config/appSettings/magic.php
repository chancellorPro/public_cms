<?php

/**
 * Magic config
 */
return [
    'name'    => 'Magic',
    'counter' => 'magics_counter',
    'fields'  => [
        'uid' => [
            'alias'       => 'uid',
            'create_type' => 'int',
            'list_type'   => 'int',
            'filter_type' => 'int',
            'validator'   => [
                'required',
                'numeric',
            ],
        ],
    ],
];
