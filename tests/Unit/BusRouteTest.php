<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class BusRouteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_not_have_empty_route()
    {
        $this->withoutExceptionHandling();

        $route1 = factory('App\Route')->create();

        $route2 = factory('App\Route')->create();

        $bus = factory('App\Bus')->create();
        
        $attributes = [
            'routes' => '',
        ];
        
        $userRole = UserRoleFactory::setAs('super_admin')->create();        

        $this->expectException(\Illuminate\Validation\ValidationException::class); //assert

        $response = $this->actingAs($userRole['user'])
                        ->post('/bus-route/'.$bus->id, $attributes);
        			//->assertSessionHasErrors('routes');  
    }
}
