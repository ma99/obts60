<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SeatPlan;
use Faker\Generator as Faker;

$seatList = [
	    		[ 'no' => 'A1', 'status' => 'available', 'checked' => true, 'special' => false ],
	    		[ 'no' => 'A2', 'status' =>  'available', 'checked' =>  true, 'special' => false ],
	    		[ 'no' => 'A3', 'status' => 'available', 'checked' =>  true, 'special' => false ],
	    		[ 'no' => 'A4', 'status' =>  'available', 'checked' =>  true, 'special' => false ],
	    		[ 'no' => 'B1', 'status' =>  'available', 'checked' =>  true, 'special' => false ],
	    		[ 'no' => 'B2', 'status' =>  'available', 'checked' =>  true, 'special' => false ],
	    		[ 'no' => 'B3', 'status' =>  'available', 'checked' =>  true, 'special' => false ],
	    		[ 'no' => 'B4', 'status' =>  'available', 'checked' =>  true, 'special' => false ],
	    	];
$factory->define(SeatPlan::class, function (Faker $faker) use ($seatList) {
    return [
    	// 'seat_list'	=> serialize(json_decode(, true)),
    	'seat_list'	=> $seatList,
    	'total_seats' => 8
    ];
});
