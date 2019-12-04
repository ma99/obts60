<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class BusControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function busData()
    {
        $seatPlan = factory('App\SeatPlan')->create(); 

        return [
            'seat_plan_id' => $seatPlan->id,
            'reg_no' => $this->faker->randomNumber($nbDigits = 5),
            'number_plate' => $this->faker->numerify('DHK#####'),
            'type' => 'ac',
            'description' => $this->faker->text($maxNbChars = 100)
        ];
    }

    /** @test */
    public function a_bus_can_be_added_by_super_admin()
    {
        $this->withoutExceptionHandling();
        
        $attributes = $this->busData();

        $userRole = UserRoleFactory::setAs('super_admin')->create();

        $response = $this->actingAs($userRole['user'])->post('/buses', $attributes);        

        $this->assertDatabaseHas('buses', $attributes);
    }

    /** @test */
    public function a_bus_can_be_added_by_admin()
    {
        $this->withoutExceptionHandling();
        
        $attributes = $this->busData();

        $userRole = UserRoleFactory::setAs('admin')->create();

        $response = $this->actingAs($userRole['user'])->post('/buses', $attributes);        

        $this->assertDatabaseHas('buses', $attributes);
    }

}
