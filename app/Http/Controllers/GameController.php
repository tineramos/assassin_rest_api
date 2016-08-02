<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class GameController extends Controller
{
    public function index()
    {
      $games = Game::all();
      return response()->json($games);
    }

    public function getGame($game_id)
    {
      $game = Game::find($game_id);
      return response()->json($game);
    }
}

?>
