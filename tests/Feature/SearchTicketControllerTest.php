<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTicketControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setData()
    {
        $user = factory('App\User')->create();
        $routes = factory('App\Route', 2)->create();
        $buses = factory('App\Bus', 3)->create();

        $route2 = factory('App\Route')->create();
        
        $schedule1 = factory('App\Schedule')->create();
        $schedule2 = factory('App\Schedule')->create();
        $schedule3 = factory('App\Schedule')->create();
        $schedule4 = factory('App\Schedule')->create();
        $schedule5 = factory('App\Schedule')->create();

        $route = \App\Route::first();
        $bus = \App\Bus::first();
        //dd($route);
        $booking1 = factory('App\Booking')->create([
            'schedule_id' => $schedule1->id,
            'bus_id' => $bus->id,
        ]);
                
        $bus->routes()->attach([$route->id]);
        
        $bus->routes()->attach([$route2->id]);
        // $bus->schedules()->attach(
        //     [$schedule1->id, $schedule2->id, $schedule3->id], 
        //     ['route_id' => $route->id]
        // );
        $bus->schedules()->attach(
            [$schedule1->id, $schedule2->id, $schedule3->id], 
            ['route_id' => $route->id]
        );

        $bus->schedules()->attach(
            [$schedule4->id, $schedule5->id], 
            ['route_id' => $route2->id]
        );

        $bus1 = factory('App\Bus')->create();
        $bus1->routes()->attach([$route->id]);


        $booking2 = factory('App\Booking')->create([
            'creator_id' => $user->id,
            'bus_id' => $bus->id,          
            'schedule_id' => $schedule2->id,
            'date' => '20-10-2022'
        ]);

        return json_decode(json_encode([
            'route' => $route, 
            'bus'   => $bus,
            'schedules' => [
                's1' => $schedule1,
                's2' => $schedule2,
                's3' => $schedule3,
                's4' => $schedule4,
                's5' => $schedule5,
            ]
        ]));
    }

    /** @test */
    public function a_bus_ticket_can_be_searched()
    {
        $this->withoutExceptionHandling();

        $data = $this->setData();        
        
        $route = $data->route;        

        $attributes = [
            'from' => $route->departure_city,
            'to'   => $route->arrival_city,
            'date' => '20-10-2022'
        ];

        //$response = $this->get('/search', $attributes)->assertStatus(200);
        $response = $this->json('GET', '/search', $attributes)->assertStatus(200);
        
        //$response->dump();    
    }

    /** @test */
    public function a_bus_has_seats_with_booking()
    {
        $this->withoutExceptionHandling();

        $data = $this->setData();        
        
        $bus = $data->bus;        
        $schedule = $data->schedules->s2;

        $attributes = [
            'schedule_id' => $schedule->id,
            'bus_id' => $bus->id,
            'bus_fare' => 800,
        ];

        //$response = $this->get('/viewseats', $attributes)->assertStatus(200);
        $response = $this->json('GET', '/viewseats/buses/'.$bus->id, $attributes)->assertStatus(200);        
    }

    /** @test */
    public function a_bus_has_seats_without_booking() //without booking
    {
        $this->withoutExceptionHandling();

        $data = $this->setData();        
        
        $bus = $data->bus;        
        $schedule = $data->schedules->s3;

        $attributes = [
            'schedule_id' => $schedule->id,
            'bus_id' => $bus->id,
            'bus_fare' => 800,
        ];
     
        $response = $this->json('GET', '/viewseats/buses/'.$bus->id, $attributes)->assertStatus(200);        
    }
}
