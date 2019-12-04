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

    public function stops()
    {
    	return $this->hasMany(Stop::class);
    }
    
	public function path()
	{
	    return "/cities/{$this->id}";
	}
}
