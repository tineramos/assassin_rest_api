<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Player;
use App\Model\Defence;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use PushNotification;

/**
 *
 */
class GamePlayController extends Controller
{

    // get target details
    public function getTarget($user_id, $player_id)
    {
        $match = ['user_id' => $user_id, 'player_id' => $player_id];
        $player = Player::where($match)->first();

        if (!is_null($player)) {
            // get the player entry of your target
            $target = Player::find($player->target_id);

            // get custom user details of the target from User table
            return response()->json($target->targetDetails(), 200, [], JSON_NUMERIC_CHECK);
        }
        else {
            return response()->json(['error' => 'Not a valid player.']);
        }
    }

    /*
     *  Get ammo (combined weapon/defence), separate weapon/defence API method
     */
    private function getAmmo($player_id, $mode)
    {
        $player = Player::find($player_id);

        if (is_null($player)) {
            // TODO: send error that player does not exist
            echo "player does not exists";
        }
        else {
            $game = $player->gameplay;

            if (is_null($game)) {
                // TODO: send error that game does not exist
                echo "game does not exists";
            }
            else {
                // player and game exists, game is ongoing
                if ($game->game_status == "ongoing") {
                    // get weapons
                    // echo $player->defences;
                    // 1 - weapon, 2 - defence, 3 - all
                    if ($mode == 1) {
                        return response()->json(["weapons" => $player->formattedWeapons()],
                                                 200, [], JSON_NUMERIC_CHECK);
                    }
                    else if ($mode == 2) {
                        return response()->json(["defences" => $player->formattedDefences()],
                                                 200, [], JSON_NUMERIC_CHECK);
                    }
                    else if ($mode == 3) {
                        return response()->json(["weapons" => $player->formattedWeapons(),
                                                 "defences" => $player->formattedDefences()],
                                                 200, [], JSON_NUMERIC_CHECK);
                    }
                    else {
                        echo "Invalid Mode";
                    }

                }
                else {
                    // TODO: send error that status of game is not ongoing
                    echo "game not ongoing";
                }
            }
        }
    }

    // 1 - weapon, 2 - defence, 3 - all
    public function getWeapons($player_id)
    {
        return $this->getAmmo($player_id, 1);
    }

    // get list of defences chosen by the player
    public function getDefences($player_id)
    {
        return $this->getAmmo($player_id, 2);
    }

    // get list of weapons chosen by the player
    public function allAmmo($player_id)
    {
        return $this->getAmmo($player_id, 3);
    }

    public function attack(Request $request)
    {
        $player_id = $request->input('player_id');
        $target_id = $request->input('target_id');
        $game_id = $request->input('game_id');
        $weapon_id = $request->input('weapon_id');
        $damage = $request->input('damage');

        $assassin = Player::find($player_id);
        $target = Player::find($target_id);

        //continue to process - player is attacking the right target
        if ($assassin->target_id == $target->player_id) {
            $device_token = $target->getPlayerDeviceTokenAttribute();
            $deviceTokenTwo = $assassin->getPlayerDeviceTokenAttribute();
            $message = "You are being attacked.";

            // echo "target: " . $target;
            // echo "one: " . $device_token;
            // echo "two: " . $deviceTokenTwo;

            // $this->sendNotificationToDevice($device_token, $message);

            foreach ($assassin->weapons as $weapon) {
                if ($weapon->weapon_id == $weapon_id) {
                    $deduction = $this->weaponTrackerMatrix($weapon_id);
                    $weapon->pivot->shots_left -= $deduction;
                    // $weapon->pivot->save();
                }
            }

            // check for defences
            foreach ($target->defences as $defence) {

                if ($defence->pivot->in_use == true && $defence->pivot->quantity > 0) {
                    $defence_id = $defence->defence_id;
                    $messageToAssassin = "";

                    // look up in matrix
                    $damage_ratio = $this->lookUpAtMatrix($defence_id, $weapon_id);
                    // echo "damage_ratio" . $damage_ratio;
                    if ($damage_ratio > 0) {

                        $damage = $damage/$damage_ratio;

                        // echo "damage: " . $damage;

                        $target->health_points -= $damage;
                        $target->save();

                        $message = $damage . " points deducted.";
                        $messageToAssassin = "Attack successful.";

                    }
                    else {
                        if ($damage_ratio == 0) {
                            $message = "No damage sustained.";
                            $messageToAssassin = "Attack not successful.";
                        }
                        else {
                            $message = "No damage but defence was broken.";
                            $messageToAssassin = "Attack not successful.";

                            $defence->pivot->in_use = false;
                            $defence->pivot->quantity--;
                            $defence->pivot->authorize_usage = false;

                        }

                    $this->sendNotificationToDevice($deviceTokenTwo, $messageToAssassin);
                    $this->sendNotificationToDevice($device_token, $message);

                    break;
                    }

                }
                else {
                    // echo "damage: " . $damage;

                    $target->health_points -= $damage;
                    $target->save();

                    $message = $damage . " points deducted.";
                    $messageToAssassin = "Attack successful.";

                    $this->sendNotificationToDevice($deviceTokenTwo, $messageToAssassin);
                    $this->sendNotificationToDevice($device_token, $message);
                }

            return response()->json(['success' => true]);

            }
        }
        else {
            abort(405, 'Target not valid.');
        }
    }

    public function lookUpAtMatrix($defence_id, $weapon_id) {

        // legend: 0 - no damage,
        // 1 - full damage,
        // 2 - half damage,
        // -1 - no damage but one less defence
        $damageMatrix = array(
            array(0, 1, 2, -1, 0),
            array(0, 1, 0, 1, 0),
            array(1, 0, 1, 1, 1),
            array(-1, -1, -1, -1, -1),
            array(0, 0, 0, 0, 0),
        );

        return $damageMatrix[$defence_id][$weapon_id];

    }

    public function weaponTrackerMatrix($weapon_id) {

        $shots_matrix = array(1, 1, 0, 1, 0);
        return $shots_matrix[$weapon_id];
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

    public function sendNotificationToDevice($device_token, $message) {

        $pushNotif = PushNotification::app(['environment' => 'development',
                                            'certificate' => base_path('confirm.pem'),
                                            'passPhrase'  => '',
                                            'service'     => 'apns']);
        $pushNotif->to($device_token)->send($message);

    }

}

?>
