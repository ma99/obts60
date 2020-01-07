<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fare;
use Faker\Generator as Faker;

$factory->define(Fare::class, function (Faker $faker) {
    return [
    	'route_id' => factory('App\Route'),
    	'city_id' => factory('App\City'),
    	'details' => json_encode([
		    'ac' => $faker->numerify('8##'),
		    'non-ac' => $faker->numerify('5##'),
		    'deluxe' =>$faker->numerify('9##') 
    	])
    ];
});
