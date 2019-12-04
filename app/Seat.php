<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $guarded = [];
    
    public function booking()
    {
    	return $this->belongsTo(Booking::class);
    }
}
