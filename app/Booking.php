<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];
    
    public function setDateAttribute($value)
    {
    	return $this->attributes['date'] = date("Y-m-d", strtotime($value));
    }

    public function getDateAttribute($value)
    {
    	return date("d-m-Y", strtotime($value));
    }

    public function seats()
    {
    	return $this->hasMany(Seat::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
