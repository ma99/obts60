<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class BusScheduleControllerTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function it_can_add_schedule_for_bus()
    {
        //$this->withoutExceptionHandling();     

        $bus = factory('App\Bus')->create();

        $schedules = factory('App\Schedule', 3)->create(); 

        foreach ($schedules as $schedule) {
            $scheduleIds[] = $schedule->id;
        }

        $attributes = [          
            'schedules' => $scheduleIds
        ];        

        $userRole = UserRoleFactory::setAs('admin')->create();        

        $response = $this->actingAs($userRole['user'])
                        ->post('/bus-schedule/'.$bus->id, $attributes);        
        
        $schedule = $schedules->first();

        $this->assertEquals($schedule->id, $bus->schedules()->first()->id);
    }
}
