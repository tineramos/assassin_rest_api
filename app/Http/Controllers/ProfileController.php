<?php

namespace App\Http\Controllers;

use App\Model\Profile;
use App\Model\Game;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
 *
 */
class ProfileController extends Controller
{
    public function getProfile($user_id)
    {
        $profile = Profile::find($user_id);
        return response()->json('profile' => $profile);
    }

    public function getProfileWithGames($user_id)
    {
        $profile = Profile::find($user_id);

        $games = Game::where('user_id', $user_id)->get();

        // TODO: get and append games!!
        // compute total and won games plus average kill per game

        return response()->json('profile' => $profile,
                                'games' => $games,
                                200, [], JSON_NUMERIC_CHECK);
    }

}

?>
