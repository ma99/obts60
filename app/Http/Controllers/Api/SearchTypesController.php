<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Type;

class SearchTypesController extends Controller
{
   public function index()
   {
    $error = ['error' => 'Type Not Found']; 

    //$routes = Type::with('cities')->get();
    $types = Type::all();
    //dd($types);
    return $types->count() ? $types : $error;
   }
}
