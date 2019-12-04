<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schedule;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {

	$departure_time = $this->faker->time($format = 'g:i A', $max = 'now'); //'8:30AM',           

	return [
		'departure_time' => $departure_time, 
        'arrival_time' => date('g:i A',  strtotime($departure_time) + strtotime('0530')), 
    ];
});
