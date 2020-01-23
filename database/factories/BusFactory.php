<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bus;
use Faker\Generator as Faker;

$factory->define(Bus::class, function (Faker $faker) {
    return [
        'seat_plan_id' => factory('App\SeatPlan'),
        'type_id' => factory('App\Type'),
        'reg_no' => $this->faker->randomNumber($nbDigits = 5),
        'number_plate' => $this->faker->numerify('DHK#####'),
        'description' => $this->faker->text($maxNbChars = 100)
    ];
});
