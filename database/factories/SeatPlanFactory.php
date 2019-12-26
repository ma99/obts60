<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SeatPlan;
use Faker\Generator as Faker;

$seatList = [
	    		[ 'no' => 'A1', 'status' => 'available', 'checked' => true ],
	    		[ 'no' => 'A2', 'status' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'A3', 'status' => 'available', 'checked' =>  true ],
	    		[ 'no' => 'A4', 'status' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B1', 'status' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B2', 'status' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B3', 'status' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B4', 'status' =>  'available', 'checked' =>  true ],
	    	];
$factory->define(SeatPlan::class, function (Faker $faker) use ($seatList) {
    return [
    	// 'seat_list'	=> serialize(json_decode(, true)),
    	'seat_list'	=> $seatList,
    	'total_seats' => 8
    ];
});
