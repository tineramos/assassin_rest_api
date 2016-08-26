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

    public function attack(Request $request)
    {
        $player_id = $request->input('player_id');
        $target_id = $request->input('target_id');
        $game_id = $request->input('game_id');
        $weapon_id = $request->input('weapon_id');
        $damage = $request->input('damage');

        $player = Player::find($player_id);
        $target = Player::find($target_id);

        //continue to process - player is attacking the right target
        if ($player->target_id == $target->player_id) {
            $deviceToken = $target->getPlayerDeviceTokenAttribute();
            $message = "You are being attacked.";
            $this->sendNotificationToDevice($deviceToken, $message);
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

    public function sendNotificationToDevice($deviceToken, $message) {

        $pushNotif = PushNotification::app(['environment' => 'development',
                                            'certificate' => base_path('confirm.pem'),
                                            'passPhrase'  => '',
                                            'service'     => 'apns']);
        $pushNotif->to($deviceToken)->send($message);

    }

}

?>
