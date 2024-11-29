<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sitemap:generate')->daily();

        $schedule->command('cashier:run')
            ->hourly() // run as often as you like (daily, monthly, every minute, ...)
            ->withoutOverlapping(); // make sure to include this
            
        $schedule->command('app:send-registration-notifications')->everyMinute();

        // Run every day at 00:00 (UTC), 08:00, 12:00 and 17:00
        $schedule->command('app:update-funds')
            ->at('00:00');

        $schedule->command('app:update-funds')
            ->timezone('Europe/Amsterdam')
            ->at('08:00');

        $schedule->command('app:update-funds')
            ->timezone('Europe/Amsterdam')
            ->at('12:00');

        $schedule->command('app:update-funds')
            ->timezone('Europe/Amsterdam')
            ->at('17:00');

        // Run every Saturday and Sunday at 12:00
        $schedule->command('app:extrapolate-funds')
            ->timezone('Europe/Amsterdam')
            ->weekends()
            ->at('12:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
