<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
 
    protected $guarded = [];

    public function addFareForRoute($route, $fare)
    {
    	$this->fare()->updateOrCreate(
            ['route_id' => $route->id],
            ['details' => $fare]
        );
    }

    public function addOrUpdateRoute($arraivalCity, $departureCity, $distance)
    {
    	# code...
    	return $this->updateOrCreate(
            ['departure_city' => $departureCity, 'arrival_city' => $arraivalCity ],
            ['distance' => $distance]
        );
    }

    public function fare()
    {
    	return $this->hasOne(Fare::class); 
    }
    
}
