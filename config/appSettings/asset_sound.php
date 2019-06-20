<?php

/**
 * Sound config
 */
return [
    'name'    => 'Sound',
    'counter' => 'sounds_counter',
    'fields'  => [
        'id'          => [
            'id'               => 'id',
            'create_type'      => 'int',
            'list_type'        => 'int',
            'filter_type'      => 'int',
            'table_head_class' => 'col-md-1',
            'validator'        => [
                'required',
                'numeric',
            ],
        ],
        'asset_id'    => [
            'alias'            => 'aid',
            'create_type'      => 'int',
            'list_type'        => 'int',
            'filter_type'      => 'int',
            'table_head_class' => 'col-md-1',
            'validator'        => [
                'required',
                'string',
            ],
        ],
        'volume'      => [
            'alias'            => 'v',
            'create_type'      => 'int',
            'list_type'        => 'int',
            'filter_type'      => 'int',
            'table_head_class' => 'col-md-1',
            'validator'        => [
                'required',
                'string',
            ],
        ],
        'is_active'      => [
            'alias'            => 'is_active',
            'create_type'      => 'int',
            'list_type'        => 'int',
            'filter_type'      => 'int',
            'table_head_class' => 'col-md-1',
            'validator'        => [
                'required',
                'string',
            ],
        ],
    ],
];
