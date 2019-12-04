<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\UserRoleFactory;
use Tests\TestCase;

class UserRoleControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_super_admin_can_assign_role_to_user()
    {
        //$this->withoutExceptionHandling();     

        $user = factory('App\User')->create();        

        $userRole = UserRoleFactory::setAs('super_admin')->create();        
        
        $response = $this->actingAs($userRole['user'])
                        ->post('/users/'.$user->id.'/roles/'.$userRole['role']->id);

        $this->assertEquals('super_admin', $user->roles()->first()->name);
    }
}
