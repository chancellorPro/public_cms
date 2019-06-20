<?php

/**
 * Default assets for Shop Admin
 */
return [
    'name' => 'Shop Admin Default Assets',
    'counter' => 'shop_admin_default_assets_counter',
    'fields' => [
        'asset_id' => [
            'create_type' => 'int',
            'list_type' => 'int',
            'filter_type' => 'int',
            'validator' => [
                'required',
                'numeric',
                'exists:assets,id',
            ],
        ],
        'sellable' => [
            'create_type' => 'bool',
            'list_type' => 'bool',
            'filter_type' => 'bool',
        ],
        'data' => [
            'create_type' => 'embed',
            'list_type' => 'embed',
            'filter_type' => 'embed',
            'embed' => [
                'instanceId' => [
                    'create_type' => 'int',
                    'list_type' => 'int',
                    'filter_type' => 'int',
                    'validator' => [
                        'required',
                        'numeric',
                    ],
                ],
                'isBackAsset' => [
                    'create_type' => 'bool',
                    'list_type' => 'bool',
                    'filter_type' => 'bool',
                    'validator' => [
                        'required',
                        'boolean',
                    ],
                ],
            ],
        ],
    ],
];