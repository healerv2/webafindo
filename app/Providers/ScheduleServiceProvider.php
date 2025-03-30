<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('mikrotik:monitor')
                ->everyFiveMinutes()
                ->withoutOverlapping();
        });
    }
}
