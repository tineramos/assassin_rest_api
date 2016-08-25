<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function loginUser(Request $request)
    {
        $code_name = $request->input('code_name');
        $password = $request->input('password');

        $match = ['code_name' => $code_name, 'password' => $password];
        $has_user = User::where($match)->first();

        if (!is_null($has_user)) {

        }
        else {

        }
    }
}

?>
