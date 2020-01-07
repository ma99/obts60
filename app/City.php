<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function district()
    {
    	return $this->belongsTo(District::class);
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class); 
    }

    public function stops()
    {
    	return $this->hasMany(Stop::class);
    }

    public function fares()
    {
        return $this->hasMany(Fare::class);
    }

    public function cityFareBy($route)
    {
        return $this->hasMany(Fare::class)
                    ->where('route_id', $route->id)->first();
    }
    
	public function path()
	{
	    return "/cities/{$this->id}";
	}
}
