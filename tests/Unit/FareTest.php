<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    // /** @test */
    // public function it_has_a_fare_by_bus_type()
    // {
    // 	$this->withoutExceptionHandling();

    // 	$bus = factory('App\Bus')->create();

    //     $route = factory('App\Route')->create();

    // 	$fareOfAcBus =json_decode($route->fare->details)->ac;

    // 	$fareByBusType = $route->getFareByBus($bus->type); //ac  BusFactory  	

    // 	$this->assertEquals($fareOfAcBus, $fareByBusType);
    // }

    /** @test */
    public function city_has_a_fare_by_route_and_bus_type()
    {
        $this->withoutExceptionHandling();

        $bus = factory('App\Bus')->create();
        $route = factory('App\Route')->create();
        $cities = factory('App\City', 3)->create();
        $route->cities()->attach($cities);
        
        $city = \App\City::first();

        $fare = factory('App\Fare')->create([
            'city_id' => $city->id, 
            'route_id' => $route->id, 
        ]);
        
        $fareOfAcBus =json_decode($city->cityFareBy($route)->details)->ac;        

        $fareByBusType = $city->cityFareBy($route)->getFareByBus($bus->type); //ac  BusFactory     

        $this->assertEquals($fareOfAcBus, $fareByBusType);
    }
}
