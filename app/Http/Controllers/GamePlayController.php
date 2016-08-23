<?php

namespace App\Http\Controllers;

use App\Player;
use App\Defence;

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
        $target = Player::find($target_id);

        // continue to process of player is attacking the right target
        if ($player->target_id == $target_id) {

        }
        else {
            abort(405, 'Target not valid.');
        }
    }

    public function defend(Request $request)
    {
        $player_id = $request->input('player_id');
        $defence_id = $request->input('defence_id');

        $defence = Defence::find($defence_id);

        foreach ($defence->players as $player) {

            if ($player->pivot->player_id == $player_id &&
                $player->pivot->authorize_usage == true) {
                    $player->pivot->in_use = true;
                    $player->pivot->save();
                    return response()->json(['success' => true]);
            }
        }

        abort(406, 'Defence can not be used.');

    }

}

?>
