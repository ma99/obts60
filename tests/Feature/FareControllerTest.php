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

        $city = factory('App\City')->create();
        $route = factory('App\Route')->create();

        $fareDetails = [ 
            'ac' => $faker->numerify('8##'),
            //'non-ac' => $faker->numerify('5##'),
            'nonac' => $faker->numerify('5##'),
            'economyac' => $faker->numerify('6##'),
            'businessac' =>$faker->numerify('9##'),
            'ac|deluxe' => [
                            'ac' => $faker->numerify('85#'),
                            'deluxe' => $faker->numerify('12##'),
                            ],
        ]; 

        $attributes = [
            'city_id' => $city->id,
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
        
        $city = factory('App\City')->create();
        
        $fare = factory('App\Fare')->create([
            'city_id' => $city->id, 
            'route_id' => $route->id,
        ]);
        

        $fareDetails = [ 
            'ac' => $faker->numerify('8##'),
            //'non-ac' => $faker->numerify('5##'),
            'nonac' => $faker->numerify('5##'),
            'economyac' => $faker->numerify('6##'),
            'businessac' =>$faker->numerify('9##'),
            'ac|deluxe' => [
                            'ac' => $faker->numerify('95#'),
                            'deluxe' => $faker->numerify('12##'),
                            ],
        ]; 

        $attributes = [
            'city_id' => $city->id,
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
