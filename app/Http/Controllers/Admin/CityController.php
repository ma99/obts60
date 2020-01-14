<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    public function store()
    {   
        $attributes = $this->validateRequest();

        return $city = City::create($attributes);    	 
    }

    public function destroy(City $city)
    {        
        $city->delete();
        return 'deleted';                    
    }

    protected function validateRequest()
    {
        return request()->validate([
           'district_id' => 'required',
           'name'  => 'required'
        ]);
    }
}