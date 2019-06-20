<?php

use \App\Models\Cms\Asset;

return [
    'animator_role_id' => 3,
    'artist_role_id' => 4,
    'adp_file_types' => [
        'reference' => 1,
        'source'    => 3,
        'animation' => 4,

        /**
         * Bundles
         */
        'compressed'           => 2,
        'uncompressed'         => 5,
        'android_compressed'   => 6,
        'android_uncompressed' => 7,
        'ios_compressed'       => 8,
        'ios_uncompressed'     => 9,
    ],
    'asset_file_path' => [
        2 => 'WebGL/SD',
        5 => 'WebGL/HD',
        6 => 'Android/SD',
        7 => 'Android/HD',
        8 => 'iOS/SD',
        9 => 'iOS/HD',
    ],
    'adp_file_bundles_config' => [
        'compressed'   => 0,
        'uncompressed' => 1,
        'both'         => 2,
    ],
    'attribute_value_types' => [
        ['id' => 'bool',   'name' => 'bool'],
        ['id' => 'int',    'name' => 'int'],
        ['id' => 'enum',   'name' => 'enum'],
        ['id' => 'float',  'name' => 'float'],
        ['id' => 'string', 'name' => 'string'],
    ],

    'asset_types' => [
        ['id' => Asset::ASSET_TYPE_FURNITURE,       'name' => 'Furniture'],
        ['id' => Asset::ASSET_TYPE_CLOTHES,         'name' => 'Clothes'],
        ['id' => Asset::ASSET_TYPE_BANNER,          'name' => 'Banner'],
        ['id' => Asset::ASSET_TYPE_LINKED,          'name' => 'Linked Object'],
        ['id' => Asset::ASSET_TYPE_BODY_PART,       'name' => 'Body Part'],
        ['id' => Asset::ASSET_TYPE_COLLECTION_ITEM, 'name' => 'Collection Item'],
        ['id' => Asset::ASSET_TYPE_FOOD_ITEM,       'name' => 'Food Item'],
        ['id' => Asset::ASSET_TYPE_MEAL,            'name' => 'Meal'],
    ],

    'initial_user_placement_types' => [
        ['id' => 'house',   'name' => 'House'],
        ['id' => 'storage', 'name' => 'Storage/Closet'],
        
    ],
    'initial_user_placement_groups' => [
        ['id' => 'house',   'name' => 'House'],
        ['id' => 'storage', 'name' => 'Storage/Closet'],
    ],
    'ai_state_types' => [
        ['id' => 1, 'name' => 'ACTION'],
        ['id' => 2, 'name' => 'WELCOME'],
        ['id' => 3, 'name' => 'STAND'],
        ['id' => 4, 'name' => 'SIT'],
        ['id' => 5, 'name' => 'SLEEP'],
        ['id' => 6, 'name' => 'WALK'],
        ['id' => 7, 'name' => 'RUN'],
    ],
    'ai_behaviour_state_types' => [
        ['id' => 1, 'name' => 'ACTION'],
        ['id' => 3, 'name' => 'STAND'],
        ['id' => 4, 'name' => 'SIT'],
        ['id' => 5, 'name' => 'SLEEP'],
        ['id' => 6, 'name' => 'WALK'],
    ],
    'ai_condition_types' => [
        ['id' => 1, 'name' => 'TIRED'],
        ['id' => 2, 'name' => 'RESTED'],
        ['id' => 3, 'name' => 'BORED'],
        ['id' => 4, 'name' => 'HUNGRY'],
    ],
    'ai_object_types' => [
        ['id' => 1, 'name' => 'PET'],
        ['id' => 2, 'name' => 'ASSET'],
    ],
    'gender' => [
        ['id' => 1, 'name' => 'MALE'],
        ['id' => 2, 'name' => 'FEMALE'],
    ],
    'rarity' => [
        ['id' => 1, 'value' => 'common'],
        ['id' => 2, 'value' => 'uncommon'],
        ['id' => 3, 'value' => 'rare'],
    ],
    'shop_admin_type' => [
        ['id' => 1, 'value' => 'live'],
        ['id' => 2, 'value' => 'adp'],
    ],
    'currency' => [
        ['id' => 1, 'value' => 'USD'],
    ],
    'localizations' => [
        ['id' => 'en', 'value' => 'English', 'validation' => 'required'],
        ['id' => 'ru', 'value' => 'Russian', 'validation' => 'nullable'],
    ],
    'neighbor_activity_target' => [
        ['id' => 1, 'name' => 'Neighbor'],
        ['id' => 2, 'name' => 'Playmate'],
    ],
    'insert_type' => [
        ['id' => 1, 'name' => 'Create'],
        ['id' => 2, 'name' => 'Age'],
        ['id' => 3, 'name' => 'Paid'],
        ['id' => 4, 'name' => 'Fcd'],
        ['id' => 5, 'name' => 'Day'],
    ],
    'whitelist_countries' => [
        ['id' => 1, 'name' => 'UA'],
        ['id' => 2, 'name' => 'US'],
        ['id' => 3, 'name' => 'GB'],
        ['id' => 4, 'name' => 'CA'],
        ['id' => 5, 'name' => 'AU'],
        ['id' => 6, 'name' => 'IT'],
        ['id' => 7, 'name' => 'DE'],
        ['id' => 8, 'name' => 'DK'],
        ['id' => 9, 'name' => 'NL'],
        ['id' => 10, 'name' => 'FR'],
        ['id' => 11, 'name' => 'CH'],
        ['id' => 12, 'name' => 'NO'],
        ['id' => 13, 'name' => 'NZ'],
        ['id' => 13, 'name' => 'NZ'],
        ['id' => 14, 'name' => 'BE'],
        ['id' => 15, 'name' => 'SE'],
        ['id' => 16, 'name' => 'IE'],
        ['id' => 17, 'name' => 'FI'],
        ['id' => 18, 'name' => 'IS'],
        ['id' => 19, 'name' => 'PT'],
        ['id' => 20, 'name' => 'LU'],
        ['id' => 21, 'name' => 'SG'],
        ['id' => 22, 'name' => 'AT'],
    ],
    'is_active' => [
        ['id' => 1, 'name' => 'On'],
        ['id' => 2, 'name' => 'Off'],
    ],
    'cleaner' => [
        ['id' => 1, 'name' => 'On'],
        ['id' => 0, 'name' => 'Off'],
    ],
    'week_days' => [
        ['id' => 1, 'name' => 'Monday'],
        ['id' => 2, 'name' => 'Tuesday'],
        ['id' => 3, 'name' => 'Wednesday'],
        ['id' => 4, 'name' => 'Thursday'],
        ['id' => 5, 'name' => 'Friday'],
        ['id' => 6, 'name' => 'Saturday'],
        ['id' => 7, 'name' => 'Sunday'],
    ],
];
