<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Route;

class SearchRoutesController extends Controller
{
   public function index()
   {
    $error = ['error' => 'City Not Found']; 

    //$routes = Route::with('cities')->get();
    $routes = Route::all();
    //dd($routes);
    return $routes->count() ? $routes : $error;
   }
}
