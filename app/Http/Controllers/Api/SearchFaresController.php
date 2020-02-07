<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fare;

class SearchFaresController extends Controller
{
   public function index()
   {
    $error = ['error' => 'Fare Not Found']; 

    //$routes = Fare::with('cities')->get();
    $fares = Fare::all();
    //dd($fares);
    return $fares->count() ? $fares : $error;
   }
}
