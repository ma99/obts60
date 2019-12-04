<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_fare_by_bus_type()
    {
    	$this->withoutExceptionHandling();

    	$bus = factory('App\Bus')->create();

        $route = factory('App\Route')->create();

    	$fareOfAcBus =json_decode($route->fare->details)->ac;

    	$fareByBusType = $route->getFareByBus($bus->type); //ac  BusFactory  	

    	$this->assertEquals($fareOfAcBus, $fareByBusType);
    }
}
