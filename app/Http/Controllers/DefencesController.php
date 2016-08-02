<?php

namespace App\Http\Controllers;

use App\Defences;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class DefencesController extends Controller
{
    public function index()
    {
      $defences = Defences::all();
      return response()->json($defences);
    }
}

?>
