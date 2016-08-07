<?php

namespace App\Http\Controllers;

use App\Profile;
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
      return response()->json($profile);
    }
}

?>
