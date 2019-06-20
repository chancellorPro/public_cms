<?php

namespace App\Console;

use App\Console\Commands\ConfigGenerator;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 */
class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ConfigGenerator::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule Schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // phpcs:ignore
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        include base_path('routes/console.php');
    }
}
