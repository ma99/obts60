<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Schedule extends Model
{
    
    protected $guarded = [];

    public function setDepartureTimeAttribute($value)
	{
	    $this->attributes['departure_time'] = Carbon::createFromFormat('g:i A', $value)->format('H:i:s');
	}

	public function getDepartureTimeAttribute($value)
    {   
    	//return Carbon::createFromFormat('H:i:s', $value)->format('g:i A');
    	return Carbon::parse($value)->format('g:i A');
    }

    public function setArrivalTimeAttribute($value)
	{
		$this->attributes['arrival_time'] = Carbon::createFromFormat('g:i A', $value)->format('H:i:s');
	}

	public function getArrivalTimeAttribute($value)
    {   
    	//return Carbon::createFromFormat('H:i:s', $value)->format('g:i A');
    	return Carbon::parse($value)->format('g:i A');
    }

    public function buses()
    {
    	return $this->belongsToMany(Bus::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
