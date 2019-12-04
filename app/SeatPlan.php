<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatPlan extends Model
{
	protected $guarded = [];

    public function setSeatListAttribute($value)
    {
        $this->attributes['seat_list'] = serialize($value);
    }

    public function getSeatListAttribute($value)
    {   
        return unserialize($value);
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
