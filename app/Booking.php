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

    public function setSession()
    {
        session([
            'booking_id' => $this->id,
            'bus_id' => $this->bus_id,
            'schedule_id' => $this->schedule_id,
            'travel_date' => date("d-m-Y", strtotime($this->date)),
            'amount' => $this->amount
        ]);
    }

    public function getSession()
    {        
        return [
            'booking_id' => session('booking_id'),
            'bus_id' => session('bus_id'),
            'schedule_id' => session('schedule_id'),
            'travel_date' => session('travel_date'),           
            'amount' => session('amount')
        ];
    }

    public function info()
    {        
        return [
            'booking_id' => $this->id,
            'bus_id' => $this->bus_id,
            'schedule_id' => $this->schedule_id,
            'travel_date' => date("d-m-Y", strtotime($this->date)),
            'amount' => $this->amount
        ];
    }
}
