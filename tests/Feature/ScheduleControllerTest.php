<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_schedule_can_be_added()
    {
        //$this->withoutExceptionHandling();        

        $attributes = [
           'departure_time' => '8:30AM',
           'arrival_time' => '4:30PM',
        ];
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/schedules', $attributes);

        $attributes = [
           'departure_time' => Carbon::createFromFormat('g:i A', $attributes['departure_time'])->format('H:i:s'),
           'arrival_time' => Carbon::createFromFormat('g:i A', $attributes['arrival_time'])->format('H:i:s'),
        ];

        $this->assertDatabaseHas('schedules', $attributes);
    }
}
