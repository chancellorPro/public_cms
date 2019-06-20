<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_DEFAULT_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'dev' => [
            'cms' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_CMS_DEV'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_CMS_DEV'),
                'username' => env('DB_USER_CMS_DEV'),
                'password' => env('DB_PASS_CMS_DEV'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'group_admin' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_GROUP_DEV'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_GROUP_DEV'),
                'username' => env('DB_USER_GROUP_DEV'),
                'password' => env('DB_PASS_GROUP_DEV'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'user' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_USER_DEV'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_USER_DEV'),
                'username' => env('DB_USER_USER_DEV'),
                'password' => env('DB_PASS_USER_DEV'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ],
        'stage' => [
            'cms' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_CMS_LIVE'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_CMS_STAGE'),
                'username' => env('DB_USER_CMS_STAGE'),
                'password' => env('DB_PASS_CMS_STAGE'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'group_admin' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_GROUP_STAGE'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_GROUP_STAGE'),
                'username' => env('DB_USER_GROUP_STAGE'),
                'password' => env('DB_PASS_GROUP_STAGE'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'user' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_USER_STAGE'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_USER_STAGE'),
                'username' => env('DB_USER_USER_STAGE'),
                'password' => env('DB_PASS_USER_STAGE'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ],
        'live' => [
            'cms' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_CMS_LIVE'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_CMS_LIVE'),
                'username' => env('DB_USER_CMS_LIVE'),
                'password' => env('DB_PASS_CMS_LIVE'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'group_admin' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_GROUP_LIVE'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_GROUP_LIVE'),
                'username' => env('DB_USER_GROUP_LIVE'),
                'password' => env('DB_PASS_GROUP_LIVE'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'user' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST_USER_LIVE'),
                'port' => env('DB_PORT'),
                'database' => env('DB_NAME_USER_LIVE'),
                'username' => env('DB_USER_USER_LIVE'),
                'password' => env('DB_PASS_USER_LIVE'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],
        'user' => [
            'host' => env('USER_CACHE_HOST', '127.0.0.1'),
            'password' => env('USER_CACHE_PASSWORD', null),
            'port' => env('USER_CACHE_PORT', 6379),
            'database' => env('USER_CACHE_DB', 0),
        ],

    ],

];
