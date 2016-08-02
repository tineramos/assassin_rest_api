<?php

namespace App\Http\Controllers;

use App\GameInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class GameInfoController extends Controller
{
    public function getGameInfo($game_id)
    {
      $game_info = GameInfo::find($game_id);
      return response()->json($game_info);
    }
}

?>
