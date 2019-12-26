<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SeatPlan;

class SeatPlanController extends Controller
{
    
    public function store()
    {     
        $attributes = $this->validateRequest();
        //dd($attributes);//['seat_list']);
        //SeatPlan::create($attributes['seat_list']);
        $sp = SeatPlan::create($attributes);

        //return 'successfully added';
        return $sp; 
    }

    public function destroy(SeatPlan $seatplan)
    {
        $error = ['error' => 'No results found'];
        
        if($seatplan) {
            $seatplan->delete();
            return 'success';            
        }
        return $error;
    }
    
    protected function validateRequest()
    {
        return request()->validate([                        
            'seat_list.*.*' => 'required',
            'total_seats' => 'required'
        ]);
    }
}