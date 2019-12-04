<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;
use App\City;
use App\Stop;

class ObtsTest extends TestCase
{
    use WithFaker, RefreshDatabase;    

    public function addStopsInfo()
    {
        $city1 = factory('App\City')->create();
        $city2 = factory('App\City')->create();

        $stops = [
            [
                'city_id' => $city1->id,
                'name' => $this->faker->streetName, 
            ],
            [
                'city_id' => $city2->id,
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
       //$this->withoutExceptionHandling();

       $district = factory('App\District')->create();       
        
       $attributes = [
            'district_id' => $district->id,
            'name'  => $district->name,
       ];
       
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/cities', $attributes);
        
        $this->assertDatabaseHas('cities', $attributes);
    }
    
    /** @test */
    public function a_city_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        factory('App\City', 3)->create();       

        $city = City::first();
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->delete('/cities/'.$city->id);
        
        $this->assertDatabaseMissing('cities', $city->toArray());
    }


    /** @test */
    public function a_stop_can_be_added()
    {
        //$this->withoutExceptionHandling();
        
        $attributes = $this->addStopsInfo();
         
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/stops', $attributes);
        
        $stop = Stop::first();

        $this->assertNotNull($stop);        
        $this->assertInstanceOf(Stop::class, $stop);
    }

    /** @test */
    public function a_stop_can_be_deleted()
    {
        //$this->withoutExceptionHandling();
        
        factory('App\Stop', 3)->create();

        $stop = Stop::first();

        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->delete('/stops/'.$stop->id);
        
        $this->assertDatabaseMissing('stops', $stop->toArray());
    }

}

