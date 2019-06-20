<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ConfigDeployed' => [
            'App\Listeners\ConfigServerNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() // phpcs:ignore
    {
        parent::boot();
    }
}
