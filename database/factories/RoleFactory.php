<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement($array = ['super_admin','admin','staff']),
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
