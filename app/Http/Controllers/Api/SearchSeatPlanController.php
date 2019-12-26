<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\SeatPlan;

class SearchSeatPlanController extends Controller
{
   public function seatPlanList()
   {
        
        $error = ['error' => 'No results found'];

        $seatPlan = SeatPlan::latest()->cursor();
        return $seatPlan->count() ? $seatPlan : $error;        
        
   }
}
