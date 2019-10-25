<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\City;

class ObtsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function addCityInfo()
    {
      
       return $attributes = [
            'city_id' => strtoupper($this->faker->lexify('???')),
            'city_name' => $this->faker->city,
            'division_name' => $this->faker->state 
        ];
    }

    public function addStopsInfo()
    {
        $stops = [
            [
                'city_id' => $this->faker->randomNumber($nbDigits = 3),
                'name' => $this->faker->streetName, 
            ],
            [
                'city_id' => $this->faker->randomNumber($nbDigits = 3),
                'name' => $this->faker->streetName,
            ]
        ];

        return $attributes = [
            'stop_list' => $stops,
        ];
    }

    /** @test */
    public function a_city_can_be_added()
    {
        
      // $this->withoutExceptionHandling();
       
        $attributes = $this->addCityInfo();
       
        $this->post('/cities', $attributes);
        
        $this->assertDatabaseHas('cities', [  
            'code' => $attributes['city_id'],
            'name' => $attributes['city_name'],
            'division' => $attributes['division_name'],
        ]);
    }
    
    /** @test */
    public function a_city_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $attributes = $this->addCityInfo();
        $this->post('/cities', $attributes);

        $city = City::first();
        //dd($city);
        $response = $this->delete('/cities/'.$city->id);
        //$response->assertOk();
        //$response->dump();

        //dd($response->content());
        $this->assertEquals('success', $response->getContent());
    }


    /** @test */
    public function a_stop_can_be_added()
    {

        $this->withoutExceptionHandling();

        $attributes = $this->addStopsInfo();
         
        $response = $this->post('/stops', $attributes);
        $response->assertOk(); 

    }

    /** @test */
    public function a_stop_can_be_deleted()
    {

        $this->withoutExceptionHandling();

        $attributes = $this->addStopsInfo(); 
        
        $this->post('/stops', $attributes); //saving

        $stop = \App\Stop::first();

        $response = $this->delete('/stops/'.$stop->id);

        //$response->assertOk(); 
       $this->assertEquals('success', $response->getContent());

    }

    /** @test */
    public function a_route_with_fare_can_be_added()
    {
        $this->withoutExceptionHandling();
        
        $fareDetails = [
            'ac' => 800,
            'non-ac' => 500,
            'deluxe' => 1200 
        ];

        $attributes = [
            'arrival_city' => $this->faker->city,
            'departure_city' => $this->faker->city,
            'distance' => $this->faker->randomNumber($nbDigits = 5),
            'fare' => json_encode($fareDetails)
        ];

        $response = $this->post('/routes', $attributes);
        //$response->assertOk(); 

        $route = \App\Route::all();        
        $this->assertEquals(1, $route->count());

        $fare = \App\Fare::all();
        $this->assertEquals(1, $fare->count());

    }

       /** @test */
    public function a_route_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $fareDetails = [
            'ac' => 800,
            'non-ac' => 500,
            'deluxe' => 1200 
        ];
        
        $attributes = [
            'arrival_city' => $this->faker->city,
            'departure_city' => $this->faker->city,
            'distance' => $this->faker->randomNumber($nbDigits = 5),
            'fare' => json_encode($fareDetails)
        ];

        $response = $this->post('/routes', $attributes);
        //$response->assertOk();

        $route = \App\Route::first();

        $response = $this->delete('/routes/'.$route->id);         
        
        $this->assertEquals(0, $route->count());

    }

    /** @test */
    public function a_fare_can_be_updated()
    {
        $this->withoutExceptionHandling();
        
        $fareDetails = [
            'ac' => 800,
            'non-ac' => 500,
            'deluxe' => 1200 
        ];
        
        $attributes = [
            'arrival_city' => $this->faker->city,
            'departure_city' => $this->faker->city,
            'distance' => $this->faker->randomNumber($nbDigits = 5),
            'fare' => json_encode($fareDetails)
        ];        

        $response = $this->post('/routes', $attributes);
        $response->assertOk();

        $fareDetails = [
            'ac' => 900,
            'non-ac' => 550,
            'deluxe' => 1200 
        ];

        $attributes = [
            'fare' => json_encode($fareDetails)
        ];
        
        $fare = \App\Fare::first();

        $this->patch('/fares/'.$fare->id, $attributes);
        
        $this->assertDatabaseHas('fares', [
            'id' => $fare->id,
            'route_id' => $fare->route_id,
            'details' => serialize(json_encode($fareDetails))
        ]);

    }
    
}

