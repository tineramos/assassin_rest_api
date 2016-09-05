<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
*
*/
class UserController extends Controller
{
    public function getUser($user_id)
    {
        $user = User::find($user_id);
        return response()->json($user, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createUser(Request $request)
    {
        $user = User::create($request->all());

        if (is_null($user)) {
            return response()->json(['success' => !is_null($user)]);
        }
        return response()->json(['success' => !is_null($user), 'user' => $user]);
    }

    public function updateUser(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $updated = $user->update($request->all());
        return response()->json(['success' => $updated]);
    }

    public function deleteUser($user_id)
    {
        $user = User::find($user_id);
        return $user->delete();
    }

    public function sendDeviceToken($user_id, $device_token)
    {
        $user = User::find($user_id);
        $user->device_token = $device_token;
        $user->save();
    }

    // returns user's details if success
    // else returns null
    public function loginUser(Request $request)
    {
        $code_name = $request->input('code_name');
        $password = $request->input('password');
        $device_token = $request->input('device_token');

        $match = ['code_name' => $code_name, 'password' => $password];
        $user = User::where($match)->first();

        if (!is_null($user)) {
            $user->device_token = $device_token;
            $user->save();
        }

        return response()->json(['success' => $user], 200, [], JSON_NUMERIC_CHECK);
    }
}

?>
