<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Route;

class RouteController extends Controller
{
	protected $request;
    
    public function __construct(Request $request)
    {   
        
        $this->request = $request;

        //$this->middleware(['auth', 'admin']);
    }


	public function store(Route $route)
    {        
        $this->validate($this->request, [
            'arrival_city' => 'required|max:50',
            'departure_city' => 'required|max:50'
        ]);

        $arraivalCity = $this->request->input('arrival_city');
        $departureCity = $this->request->input('departure_city');
        $distance = $this->request->input('distance');
      
        $route = $route->addOrUpdateRoute($arraivalCity, $departureCity, $distance); 

        $fare = $this->request->input('fare');

        $route->addFareForRoute($route, $fare); 

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
    
}
