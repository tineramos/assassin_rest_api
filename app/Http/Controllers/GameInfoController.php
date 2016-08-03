<?php

namespace App\Http\Controllers;

use App\GameInfo;
use App\Player;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class GameInfoController extends Controller
{
    public function getGameInfo($game_id, $user_id)
    {
        $game_info = GameInfo::find($game_id);
        $match = ['user_id' => $user_id, 'game_id' => $game_id];
        $hasJoined = Player::where($match)->first();

        $players = Player::where('game_id', $game_id)->get();

        return response()->json(['game' => $game_info,
                                 'players' => $players,
                                 'joined' => !is_null($hasJoined)]);
    }
}

?>
