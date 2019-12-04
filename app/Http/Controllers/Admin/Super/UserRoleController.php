<?php

namespace App\Http\Controllers\Admin\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;


class UserRoleController extends Controller
{
   public function store(User $user, Role $role)
   {
   		//$user = User::find(request('user_id'));
   		//$user->assign(request('role'));
   		//dd('here');
   		$user->assign($role);
   		//dd(auth()->user()->roles);
   		//dd($user->roles);

   		return 'success';
   }

   protected function validateRequest()
   {   	
	   	return request()->validate([	        
		        'role' => 'required',
		        'user_id' => 'required'
		]);
   }
}
