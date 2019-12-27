<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class BusScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_get_schedules_for_bus_by_route()
    {
        //$this->withoutExceptionHandling();     

        $route1 = factory('App\Route')->create();
        $route2 = factory('App\Route')->create();
        
        $bus = factory('App\Bus')->create();

        $schedules = factory('App\Schedule', 3)->create(); 
        $schedule1 = factory('App\Schedule')->create();
        $schedule2 = factory('App\Schedule')->create();

        foreach ($schedules as $schedule) {
            $scheduleIds[] = $schedule->id;
        }

        $bus->routes()->attach([$route1->id]);

        $bus->schedules()->attach(
            $scheduleIds, 
            ['route_id' => $route1->id]
        );

        $bus->routes()->attach([$route2->id]);
        
        $bus->schedules()->attach(
            [$schedule1->id, $schedule2->id], 
            ['route_id' => $route2->id]
        );
        
        $schedules = $bus->schedulesBy($route1->id)->get();
        //dd($schedules);
        //dd($schedules->count());       
       $this->assertEquals(3, $schedules->count());
    }
}
