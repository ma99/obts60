<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bus;

class BusScheduleController extends Controller
{
    public function store(Bus $bus)
    {
        $attributes = $this->validateRequest();

        $bus->schedules()->attach($attributes['schedules']); //attach

        return 'success';
    }

    protected function validateRequest()
    {
        return request()->validate([
            //'route' => 'required',
            'schedules' => 'required'
        ]);
    }
}