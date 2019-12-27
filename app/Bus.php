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
    	return $this->belongsTo(SeatPlan::class);
    }
}
