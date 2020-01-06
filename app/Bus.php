<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $guarded = [];

    public function routes()
    {
    	return $this->belongsToMany(Route::class);
    }

    public function schedules()
    {
    	return $this->belongsToMany(Schedule::class)
                    ->withPivot('route_id');
    }

    public function schedulesBy($routeId)
    {
        //return $this->belongsToMany(Schedule::class)
        return $this->schedules()
                    ->wherePivot('route_id', $routeId);
    }

    public function seat_plan()
    {
    	return $this->belongsTo(SeatPlan::class);//->latest();
    }

    /*public function getBusesWithSeatPlan()
    {
        $buses = $this::with('seat_plan')->get();
        foreach ($buses as $bus) {           
            $busList[] = [
                'bus'   => $bus,
                'total_seats' => $bus->seat_plan->total_seats
            ];
        }
        return $busList;
    }*/
}
