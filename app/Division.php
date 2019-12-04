<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];
    
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function cities()
    {
    	return $this->hasManyThrough(City::class, District::class);
    }
}
