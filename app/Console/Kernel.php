<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

use App\Game;

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
        'BasicIT\LumenVendorPublish\VendorPublishCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {

            // get the first open game of today
            $openGame = Game::where([
                            ['game_status', '=', 'open'],
                            ['open_until', '=', date('Y-m-d')],
                            ])->firstOrFail();

            // get the array of player_id of the players of the game
            $players =  $openGame->players()->select('player_id')->get();

            // for now, use shuffle method for target assignment
            shuffle($players);

            // this method will assign a target to an assassin
            for ($i = 0; $i < count($players); $i++) {

                $current_player_id = $players[$i];
                $player = Player::find($current_player_id);

                /* target assignment */
                // if current player is not the last player in array
                if ($i != (count($players) - 1)) {
                    $next_player_id = $players[$i + 1];
                    $player->target_id = $next_player_id;
                }
                // case when iteration reaches last player
                else {
                    $first_player = $players[0];
                    $player->target_id = $first_player;
                }

                /* assassin assignment - will not be accessible through API */
                // special case when assigning assassin of the first array element
                if ($i == 0) {
                    // get last player_id then assign it to the first player's assassin
                    $last_player_id = $players[count($players) - 1];
                    $player->assassin_id = $last_player_id;
                }
                else {
                    $previous_player_id = $players[$i - 1];
                    $player->assassin_id = $previous_player_id;
                }
            }

        })
        ->after(function() {
            // push notification
            echo "trigger push notification here";
        })
        ->when(function() {

        })
        ->cron('* * * * * *'); // for now use Cron for manual-trigger scheduling
    }
}
