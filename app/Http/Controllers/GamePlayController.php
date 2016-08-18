<?php

namespace App\Http\Controllers;

use App\Game;
use App\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class GamePlayController extends Controller
{
    public function attack(Request $request)
    {
        $player_id = $request->input('player_id');
        $target_id = $request->input('target_id');
        $game_id = $request->input('game_id');
        $weapon_id = $request->input('weapon_id');
        $damage = $request->input('damage');

        $player = Player::find($player_id);

        // continue to process of player is attacking the right target
        if ($player->target_id == $target_id) {

        }
        else {
            abort();
        }
    }

    public function defend(Request $request)
    {
        $player_id = $request->input('player_id');
        $game_id = $request->input('game_id');
        $defence_id = $request->input('defence_id');

        $match = ['player_id' => $player_id, 'defence_id' => $defence_id];
        $player_defence = DB::table('player_defences')->where($match)->first();
        

    }

}


?>
