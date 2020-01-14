<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\SeatPlan;

class SearchSeatPlanController extends Controller
{
   public function index()
   {
        $error = ['error' => 'No results found'];

        //$seatPlan = SeatPlan::latest()->get();
        $seatPlan = SeatPlan::cursor();
        return $seatPlan->count() ? $seatPlan : $error;        
        
   }
}
