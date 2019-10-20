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

    /** @test */
    public function a_city_can_be_added()
    {
        
      // $this->withoutExceptionHandling();
        $attributes = $this->addCityInfo();
        //dd($attributes); 
        /*$attributes = [
            'city_id' => strtoupper($this->faker->lexify('???')),
            'city_name' => $this->faker->city,
            'division_name' => $this->faker->state 
        ];*/

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
}


