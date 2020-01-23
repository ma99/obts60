<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Type;
use Faker\Generator as Faker;

$factory->define(Type::class, function (Faker $faker) {
	//$array = ['Ac','Non Ac','Economy Ac', 'Business Ac', 'Ac|Deluxe'];
	$array = ['Ac|Deluxe'];
	//$array = ['Ac'];
	$name = $this->faker->randomElement($array);
	$trimedName = preg_replace("/\s+/", "", $name);
	$key = strtolower(trim($trimedName));
    return [
        'name' => $name,
        'key' => $key
    ];
});
