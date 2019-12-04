<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Withfaker;
use Facades\Tests\Setup\UserRoleFactory;

use Tests\TestCase;

class FareControllerTest extends TestCase
{
    use Withfaker, RefreshDatabase;

    /** @test */
    public function a_fare_can_be_added()
    {
        $this->withoutExceptionHandling();

        $route = factory('App\Route')->create();

        $fareDetails = [ 
            'ac' => $this->faker->numerify('8##'),
            'non-ac' => $this->faker->numerify('5##'),
            'deluxe' => $this->faker->numerify('9##') 
        ]; 

        $attributes = [
            'route_id' => $route->id,
            'details' => json_encode($fareDetails),
        ];
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/fares', $attributes)
                        ->assertStatus(200);

        $attributes['details'] = serialize(json_encode($fareDetails));

        $this->assertDatabaseHas('fares', $attributes);
    }

    /** @test */
    public function a_fare_can_be_updated()
    {
        $this->withoutExceptionHandling();

        //$fare = factory('App\Fare')->create();
        $route = factory('App\Route')->create();
        $fare = $route->fare;
        

        $fareDetails = [ 
            'ac' => $this->faker->numerify('7##'),
            'non-ac' => $this->faker->numerify('6##'),
            'deluxe' => $this->faker->numerify('95#') 
        ]; 

        $attributes = [
            'route_id' => $fare->route_id,
            'details' => json_encode($fareDetails),
        ];

        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->patch('/fares/'.$fare->id, $attributes)
                        ->assertStatus(200);

        $attributes['details'] = serialize(json_encode($fareDetails));

        $this->assertDatabaseHas('fares', $attributes);

    }
}
