<?php

namespace App\Http\Controllers;

use App\User;
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
      return response()->json($user);
    }

    public function createUser(Request $request)
    {
      $user = User::create($request->all());

      if (is_null($user)) {
        return response()->json(['success' => !is_null($user)]);
      }
      return response()->json(['success' => !is_null($user), 'user_id' => $user->user_id]);
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
}

?>
