<?php

namespace App\Console;

use App\Console\Commands\NotificarDeOficio;
use App\Pieza;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // NotificarDeOficio::class,
        Commands\EliminarSessions::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        // $schedule->command('piezas:notificarDeOficio')->everyFiveMinutes();
        // $schedule->command('piezas:notificarDeOficio')->daily();
        // $schedule->command('test:eliminar')->everyMinute();
        $schedule->command('test:eliminar')->everyFiveMinutes();
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
