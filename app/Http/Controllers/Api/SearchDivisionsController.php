<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Division;

class SearchDivisionsController extends Controller
{
   public function index()
   {
    $error = ['error' => 'City Not Found']; 

    $divisions = Division::all();
    return $divisions->count() ? $divisions : $error;
   }
}
