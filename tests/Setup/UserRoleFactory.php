<?php

namespace Tests\Setup;

use App\User;
use App\Role;

/**
 * 
 */
class UserRoleFactory 
{
	protected $user;

	protected $role;


	public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function setAs($role)
    {
        $this->role = $role;

        return $this;
    }

    public function create()
    {        
        $user = factory('App\User')->create();
        
        $role = factory('App\Role')->create(['name' => $this->role ?? 'super_admin']);

        $user->roles()->attach($role);

        //return json_decode(json_encode([
        return [
        	'user' => $user,
        	'role' => $role,
        ];
        //]));
    }
}