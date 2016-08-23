<?php

namespace App\Http\Controllers;

use App\Game;
use App\Player;
use App\User;
use App\Profile;
use App\Weapon;
use App\Defence;
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
        return response()->json($games, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getGameInfo($game_id, $user_id)
    {
        $game = Game::find($game_id);
        $match = ['user_id' => $user_id, 'game_id' => $game_id];
        $hasJoined = Player::where($match)->first();

        $players = Player::where('game_id', $game_id)->get();

        return response()->json(['game' => $game,
                                 'players' => $players,
                                 'joined' => !is_null($hasJoined)],
                                 200, [], JSON_NUMERIC_CHECK);
    }

    public function joinGame(Request $request)
    {
        $game_id = $request->input('game_id');

        $game = Game::find($game_id);

        if (is_null($game)) {
            // TODO: throw error - game not present in DB
        }

        $game->increment('players_joined');
        $game->decrement('available_slots');
        $game->save();

        $user_id = $request->input('user_id');

        // get the corresponding user_profile object
        // if User object exists with the id but not Profile, create new Profile instance
        $profile = Profile::find($user_id);
        $user = User::find($user_id);
        if (is_null($profile) && !is_null($user)) {
            $profile = new Profile;
            $profile->user()->associate($user);
            $profile->save();
        }
        else {
            // TODO: throw error - user not present in DB
        }

        $player = new Player;
        $player->user_id = $user_id;
        $player->game_id = $game_id;
        $player->save();

        // set weapons and defences for the player
        $weapons = $request->input('weapons');
        foreach ($weapons as $weapon_id) {
            $weapon = Weapon::find($weapon_id);
            $weapon->players()->save($player);
        }

        $defences = $request->input('defences');
        foreach ($defences as $defence_id) {
            $defence = Defence::find($defence_id);
            $defence->players()->save($player);
        }

        if (is_null($player)) {
            return response()->json(['success' => !is_null($player)]);
        }

        return response()->json(['success' => !is_null($player), 'player_id' => $player->player_id]);
    }

    public function leaveGame($player_id)
    {
        $player = Player::find($player_id);

        foreach (Weapon::all() as $weapon) {
            $weapon->players()->detach($player_id);
        }

        foreach (Defence::all() as $defence) {
            $defence->players()->detach($player_id);
        }

        $game = $player->gameplay->game;
        $game->increment('players_joined');
        $game->decrement('available_slots');

        return response()->json(['success' => !is_null($player->delete())]);
    }

}

?>
