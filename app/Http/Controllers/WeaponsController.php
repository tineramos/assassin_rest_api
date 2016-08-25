<?php

namespace App\Http\Controllers;

use App\Model\Weapon;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
 *
 */
class WeaponsController extends Controller
{
    public function index()
    {
      $weapons = Weapon::all();
      return response()->json($weapons);
    }
}

?>
