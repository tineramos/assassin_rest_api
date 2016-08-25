<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

use App\Model\Game;

/*
    vendor:publish command
    Acknowledgement: https://packagist.org/packages/basicit/lumen-vendor-publish
*/

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\KeyGenerateCommand',
        'BasicIT\LumenVendorPublish\VendorPublishCommand',
        'App\Console\Commands\TargetAssignment'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function() {
        //     $check_draw = \App
        // })
        // ->after(function() {
        //     // push notification
        //     echo "trigger push notification here";
        // })
        // ->cron('* * * * * *'); // for now use Cron for manual-trigger scheduling

        $schedule->command('target-assignment')
                ->dailyAt('21:45')
                ->sendOutputTo(storage_path('logs/target-assignment.log'))
                ->emailOutputTo('sitineramos@gmail.com');

    }

}
