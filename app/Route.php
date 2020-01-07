<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
 
    protected $guarded = [];

    // public function fare()
    // {
    // 	return $this->hasOne(Fare::class); 
    // }

    public function buses()
    {
    	return $this->belongsToMany(Bus::class); 
    }

    public function cities()
    {
        return $this->belongsToMany(City::class); 
    }

    public function schedules()
    {
        return $this->hasManyThrough(Schedule::class, Bus::class); 
    }

    public function path()
	{
	    return "/routes/{$this->id}";
	}

    public function getFareByBus($type)
    {
        $fare = json_decode($this->fare->details);
        //dd($fare->ac); 

        switch ($type) {
            case "ac":
                $fare = $fare->ac;
                break;
            case "non-ac":
                $fare = $fare->non_ac;
                break;
            case "delux":
                $fare = $fare->deluxe;
                break;
            case "ac-delux":
                $fare =  $fare->ac .'/'. $fare->non_ac;;
                break;
            default:
                return 'N/A';
        }
        return $fare;
    }    
    
}
