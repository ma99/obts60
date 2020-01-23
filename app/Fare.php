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
        $fare = json_decode($this->details, true); 
        
        $result = $fare[$type] ?? 'N/A';        
        
        return $result;
    }        
}
