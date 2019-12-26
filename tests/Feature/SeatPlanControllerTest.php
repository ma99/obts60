<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;
use App\SeatPlan;

class SeatPlanControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_seatplan_can_be_added_by_super_admin()
    {
        $this->withoutExceptionHandling();
        
        $seatList = [
                [ 'no' => 'A1', 'status' => 'available', 'checked' => true ],
                [ 'no' => 'A2', 'status' =>  'available', 'checked' =>  true ],
                [ 'no' => 'A3', 'status' =>  'available', 'checked' =>  true ],
                [ 'no' => 'A4', 'status' =>  'available', 'checked' =>  true ],
                [ 'no' => 'B1', 'status' =>  'available', 'checked' =>  true ],
                [ 'no' => 'B2', 'status' =>  'available', 'checked' =>  true ],
                [ 'no' => 'B3', 'status' =>  'available', 'checked' =>  true ],
                [ 'no' => 'B4', 'status' =>  'available', 'checked' =>  true ],
            ];

        $attributes = [
            // 'seat_list'  => serialize(json_decode(, true)),
            'seat_list' => $seatList,
            'total_seats' => 8
        ];

        $userRole = UserRoleFactory::setAs('super_admin')->create();

        $response = $this->actingAs($userRole['user'])->post('/seatplans', $attributes); 

        $attributes['seat_list'] = serialize($seatList);       

        $this->assertDatabaseHas('seat_plans', $attributes);
    }

    /** @test */
    public function a_seatplan_can_be_deleted_by_super_admin()
    {
        $this->withoutExceptionHandling();

        factory('App\SeatPlan', 3)->create();
        
        $seatPlan = SeatPlan::first();        
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();

        $response = $this->actingAs($userRole['user'])
                        ->delete('/seatplans/'.$seatPlan->id);        

        $attributes = [
            'id' => $seatPlan->id,
            'seat_list' => serialize($seatPlan->seat_list),
            'total_seats' => $seatPlan->total_seats
        ];
        
        $this->assertDatabaseMissing('seat_plans', $attributes);        
    }

}
