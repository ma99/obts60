<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;
use App\Route;

class RouteControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function a_route_can_be_added()
    {
        //$this->withoutExceptionHandling();        
                
        $attributes = [
            'arrival_city' => $this->faker->city,
            'departure_city' => $this->faker->city,
            'distance' => $this->faker->randomNumber($nbDigits = 5)
        ];

        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/routes', $attributes);
        
        $this->assertDatabaseHas('routes', $attributes);
        
    }

    /** @test */    
    public function a_route_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $route = factory(Route::class)->create();

        $attributes = [
            'arrival_city' => $this->faker->city,
            'departure_city' => $this->faker->city,
            'distance' => $this->faker->randomNumber($nbDigits = 5),
        ];
         
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->patch($route->path(), $attributes);            

        $this->assertDatabaseHas('routes', $attributes);   
    }

    /** @test */
    public function a_route_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        
        factory('App\Route', 3)->create();
        
        $route = Route::first();
         
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->delete($route->path());
        
        $this->assertDatabaseMissing('routes', $route->toArray());
    
    }

}
