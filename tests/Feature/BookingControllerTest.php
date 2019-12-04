<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Withfaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
   use  Withfaker, RefreshDatabase;

   /** @test */
   public function a_user_can_create_booking()
   {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $bus = factory('App\Bus')->create(); 
        $schedule = factory('App\Schedule')->create(); 

        $seats = [
            [ 'seat_no' => 'A2', 'status' => 'booked'],
            [ 'seat_no' => 'B1', 'status' => 'booked']
        ];

        $attributes = [
            'bus_id' => $bus->id,          
            'schedule_id' => $schedule->id,          
            'total_seats' => 2,
            'date' => '20-12-2019',
            'pickup_point' => $this->faker->streetName,
            'dropping_point' => $this->faker->streetName,
            'total_fare' => $this->faker->numberBetween($min = 400, $max = 9000), // 8567,
            'selected_seats' => $seats,
        ];

        $this->actingAs($user)
                        ->post('/bookings', $attributes)
                        ->assertStatus(200);

        $this->assertDatabaseHas('seats', [ 'seat_no' => 'A2', 'status' => 'booked']);
   }


   /** @test */
   public function a_booking_creator_can_cancel_booking()
   {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();

        $booking = factory('App\Booking')->create(['creator_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->delete('/bookings/'.$booking->id)
                         ->assertRedirect(route('home'));
        
        $this->assertDatabaseMissing('seats', [ 'seat_no' => 'A2', 'status' => 'booked']);                    
   }

   /** @test */
   public function a_super_admin_can_cancel_booking()
   {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();        

        $booking = factory('App\Booking')->create(['creator_id' => $user->id]);

        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                         ->delete('/bookings/'.$booking->id)
                         ->assertRedirect(route('home'));
        
        $this->assertDatabaseMissing('seats', [ 'seat_no' => 'A2', 'status' => 'booked']);                    
   }

}
