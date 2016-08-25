<?php

namespace App\Console\Commands;

use App\Model\Game;
use App\Model\Player;
use App\Jobs\Job;
use Illuminate\Console\Command;

/**
 *
 */
class TargetAssignment extends Command
{

    protected $signature = 'target-assignment';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct(argument)
    // {
    //     # code...
    // }

    public function handle() {
        try {
            $this->comment("Update Game...");
            $this->updateGame();
        } catch (QueryException $e) {
            $this->error($e->getMessage());
        }

    }

    private function updateGame() {
        $game = Game::find(1);
        $this->comment($game->game_status);
    }

}


?>
