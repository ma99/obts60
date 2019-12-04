<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bus;
use App\Route;


class BusRouteController extends Controller
{
    
    public function store(Bus $bus)
    {
        // $routes = request()->input('routes');
        // dd($routes);

        $attributes = $this->validateRequest();
        
        $bus->routes()->attach($attributes['routes']); //attach

        return 'success';
    }

    // public function addBusesForRoute(Route $route)
    // {
    //     $buses = request()->input('buses');

    //     $route->buses()->sync($buses); //attach

    //     return 'success';
    // }


    public function destroy(Bus $bus, $route)
    {
        //$attributes = $this->validateRequest();
        
        $bus->routes()->detach($route); //attach

        return 'success';
    }

    protected function validateRequest()
    {
        return request()->validate([
            'routes' => 'required|array'
        ]);
    }
}