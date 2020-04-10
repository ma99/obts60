<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user) {            
        return [
            'id' => $user->id,
            'phone' => $user->phone,
            'name'  => $user->name,
            'email' => $user->email,
            'error' => ''
        ];
        }
        return [
            //'id' => '',
            'phone' => $phone,
            //'name'  => '',
            //'email' => '',
            //'error' => ''
        ];
    }
    
}