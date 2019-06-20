<?php

/**
 * Link Account Bonus
 */
return [
    'name' => 'Link Account Bonus',
    'counter' => 'link_account_bonus_counter',
    'fixed_rows' => true,
    'with_award' => true,
    'presets' => [
        'account_type' => '\App\Models\User\User::getAccountTypes',
    ],
    'fields' => [
        'account_type' => [
            'create_type' => 'select',
            'list_type' => 'selectViewHidden',
            'filter_type' => '',
            'validator' => [
                'required',
                'numeric',
            ],
        ],
        'award_id' => [
            'create_type' => 'int',
            'list_type' => 'award',
            'filter_type' => '',
            'validator' => [
                'required',
                'numeric',
                'exists:awards,id'
            ],
        ],
    ],
    'default_structure' => [
        [
            'account_type' => 0,
            'award_id' => null,
        ],
        [
            'account_type' => 1,
            'award_id' => null,
        ],
        [
            'account_type' => 2,
            'award_id' => null,
        ],
        [
            'account_type' => 3,
            'award_id' => null,
        ],
    ],
];