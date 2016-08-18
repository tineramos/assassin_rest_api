<?php

namespace App\Http\Controllers;

use App\Player;
use App\Weapon;
use App\Defence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function getPlayer($player_id)
    {
        $player = Player::find($player_id);
        return response()->json($player);
    }

    public function updateWeapons(Request $request, $player_id)
    {
        $player = Player::find($player_id);

        // remove old weapons
        foreach (Weapon::all() as $weapon) {
            $weapon->players()->detach($player_id);
        }

        // add new weapons
        $new_weapons = $request->input('weapons');
        foreach ($new_weapons as $weapon_id) {
            $weapon = Weapon::find($weapon_id);
            $weapon->players()->save($player);
        }

        // TODO: handle failed updates
        return response()->json(['success' => true]);
    }

    public function updateDefences(Request $request, $player_id)
    {
        $player = Player::find($player_id);

        // remove old defences
        foreach (Defence::all() as $defence) {
            $defence->players()->detach($player_id);
        }

        // add new list of defences
        $new_defences = $request->input('defences');
        foreach ($new_defences as $defence_id) {
            $defence = Defence::find($defence_id);
            $defence->players()->save($player);
        }

        // TODO: handle failed updates
        return response()->json(['success' => true]);
    }

    public function attack(Request $requestß)
    {
        $player_id = $request->input('player_id')
        $target_id = $request->input('$target_id')
        $game_id = $request->input('$game_id')
        $weapon_id = $request->input('$weapon_id')
        $damage = $request->input('damage')

        $target = Player::find($target_id)

    }

}

?>
