<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Fare;

class FareController extends Controller
{
    public function store()
    {
    	$attributes = $this->validateRequest();
        Fare::create($attributes);  

        return 'success';

    }

    public function update(Fare $fare)
    {
    	$attributes = $this->validateRequest();

        $fare->update($attributes);

        return 'success';
    }

    public function destroy(Fare $fare)
    {
        $error = ['error' => 'No results found'];
      
        if ($fare) {
            $fare->delete();
            return 'success';            
        }

        return $error;
    }

    protected function validateRequest()
    {
        return request()->validate([
           'city_id' => 'required',
           'route_id' => 'required',
           'details' => 'required'
        ]);
    }
}