<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use WithFaker, RefreshDatabase;

     /** @test */
    public function it_can_be_unique_only()
    {
        $this->withoutExceptionHandling();        
        
        $attributes = [
           'departure_time' => '8:30AM',           
           'arrival_time' => '4:30PM',
        ];

        $schedule = \App\Schedule::create($attributes);

        $this->expectException(\Illuminate\Database\QueryException::class);   //assert
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/schedules', $attributes); // act
    }
 
    /** @test */
    public function it_arrival_time_can_be_only_after_departure_time()
    {
       $this->withoutExceptionHandling();        

        $attributes = [
           'departure_time' => '8:30AM',           
           'arrival_time' => '7:30AM',
        ];

         $this->expectException(\Illuminate\Validation\ValidationException::class);   //assert

        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/schedules', $attributes);                      
    }
}
