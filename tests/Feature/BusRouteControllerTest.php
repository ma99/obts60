<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class BusRouteControllerTest extends TestCase
{
   use WithFaker, RefreshDatabase;

    /** @test */
    public function it_can_add_routes_for_bus()
    {
        $this->withoutExceptionHandling();

        $route1 = factory('App\Route')->create();

        $route2 = factory('App\Route')->create();

        $bus = factory('App\Bus')->create();
        
        $attributes = [
            'routes' => [$route1->id, $route2->id]
        ];
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/bus-route/'.$bus->id, $attributes);

        $this->assertEquals($route1->id, $bus->routes()->first()->id);
    }

    /** @test */
    public function it_can_delete_routes_for_bus()
    {
        $this->withoutExceptionHandling();

        $buses = factory('App\Bus')->create()
                   ->each(function($bus)
                   {
                     $routes = factory('App\Route', 3)->create()
                        ->each(function($route) use ($bus) {                            
                            $bus->routes()->attach($route->id);                            
                        });
                   });
              
        $bus = \App\Bus::first();

        $route = \App\Route::first();

        $userRole = UserRoleFactory::setAs('admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->delete('/bus-route/'.$bus->id.'/'.$route->id);
                        
        $this->assertEquals(2, $bus->routes()->count());       
    }
}
