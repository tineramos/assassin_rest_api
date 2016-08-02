<?php

namespace App\Http\Controllers;

use App\Defence;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class DefencesController extends Controller
{
    public function index()
    {
      $defences = Defence::all();
      return response()->json($defences);
    }
}

?>
