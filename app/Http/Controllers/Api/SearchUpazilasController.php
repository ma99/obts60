<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Upazila;

class SearchUpazilasController extends Controller
{
   public function index()
   {
    $error = ['error' => 'City Not Found']; 

    $upazilas = Upazila::all();
    return $upazilas->count() ? $upazilas : $error;
   }
}
