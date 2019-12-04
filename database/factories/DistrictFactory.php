<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\District;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
    	'division_id' => factory('App\Division'),
    	'name' => $faker->city,
    ];
});
