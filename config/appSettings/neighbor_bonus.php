<?php

/**
 * Neighbor Bonus
 */
return [
    'name' => 'Neighbor Bonus',
    'counter' => 'neighbor_bonus_counter',
    'fixed_rows' => true,
    'fields' => [
        'neighbor_qty' => [
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => '',
            'validator' => [
                'required',
                'numeric',
            ],
        ],
        'award_id' => [
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => '',
            'validator' => [
                'required',
                'numeric',
                'exists:awards,id'
            ],
        ],
        'alias' => [
            'create_type' => 'string',
            'list_type' => 'string',
            'filter_type' => '',
        ],
        'description' => [
            'create_type' => 'string',
            'list_type' => 'string',
            'filter_type' => '',
        ],
    ],
    'default_structure' => [
        [
            'neighbor_qty' => -1,
            'award_id' => null,
            'alias' => 'good_neighbor_bonus',
            'description' => 'Cleaned all trash in a room',
        ],
        [
            'neighbor_qty' => 20,
            'award_id' => null,
            'alias' => 'small_bonus',
            'description' => 'Small bonus',
        ],
        [
            'neighbor_qty' => 40,
            'award_id' => null,
            'alias' => 'big_bonus',
            'description' => 'Big bonus',
        ],
        [
            'neighbor_qty' => 20,
            'award_id' => null,
            'alias' => 'override_bonus',
            'description' => 'Override bonus (after limit)',
        ],
    ],
];