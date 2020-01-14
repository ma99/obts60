<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Route;

class RouteController extends Controller
{
	
	public function store()
    {        
    	$attributes = $this->validateRequest();

        return $route = Route::create($attributes);
    }

    public function update(Route $route)
    {
    	$attributes = $this->validateRequest();

        $route->update($attributes);  

        return 'success';	
    }

    public function destroy(Route $route)
    {
        $error = ['error' => 'No results found'];
      
        if ($route) {
            $route->delete();
            return 'success';            
        }

        return $error;
    }

    protected function validateRequest()
    {
        return request()->validate([
           'arrival_city' => 'required|max:50',
           'departure_city' => 'required|max:50',
           'distance' => 'nullable' 
        ]);
    }
    
}
