<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    
    return [
        'creator_id' => factory('App\User'),
        'bus_id' => factory('App\Bus'),          
        'schedule_id' => factory('App\Schedule'),
        'total_seats' => 2,
        'date' => $faker->date($format = 'd-m-Y', $max = 'now'),//'20-12-2019',
        'pickup_point' => $faker->streetName,
        'dropping_point' => $faker->streetName,
        'amount' => $faker->numberBetween($min = 400, $max = 9000), // 8567,
    ];
});

$seats = [
            [ 'seat_no' => 'A2', 'status' => 'booked'],
            [ 'seat_no' => 'B1', 'status' => 'booked']
];

$factory->afterCreating(Booking::class, function ($booking, $faker) use ($seats) {
    //$user->accounts()->save(factory(App\Account::class)->make());    
    foreach ($seats as $seat) {    	
        $booking->seats()->create($seat);
    }    
});