<?php

namespace App\Http\Controllers;

use App\Weapons;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class WeaponsController extends Controller
{
    public function index()
    {
      $weapons = Weapons::all();
      return response()->json($weapons);
    }
}

?>
