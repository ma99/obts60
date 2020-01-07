<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    protected $guarded = [];

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = serialize($value);
    }

    public function getDetailsAttribute($value)
    {   
        return unserialize($value);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function getFareByBus($type)
    {
        $fare = json_decode($this->details);
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
