<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Route;
use App\Fare;

$factory->define(Route::class, function (Faker $faker) {
    return [
    	'arrival_city' => $this->faker->city,
        'departure_city' => $this->faker->city,
        'distance' => $this->faker->randomNumber($nbDigits = 3),
    ];
});


$factory->afterCreating(Route::class, function ($route, $faker) {
    $route->fare()->save(factory(Fare::class)->make());
});
