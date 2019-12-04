<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stop;
use Faker\Generator as Faker;

$factory->define(Stop::class, function (Faker $faker) {
    return [
        'city_id' => factory('App\City'),
        'name' => $faker->streetName, 
    ];
});
