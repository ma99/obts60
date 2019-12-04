<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SeatPlan;
use Faker\Generator as Faker;

$seatList = [
	    		[ 'no' => 'A1', 'sts' => 'available', 'checked' => true ],
	    		[ 'no' => 'A2', 'sts' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'A3', 'sts' => 'available', 'checked' =>  true ],
	    		[ 'no' => 'A4', 'sts' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B1', 'sts' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B2', 'sts' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B3', 'sts' =>  'available', 'checked' =>  true ],
	    		[ 'no' => 'B4', 'sts' =>  'available', 'checked' =>  true ],
	    	];
$factory->define(SeatPlan::class, function (Faker $faker) use ($seatList) {
    return [
    	// 'seat_list'	=> serialize(json_decode(, true)),
    	'seat_list'	=> $seatList,
    	'total_seats' => 8
    ];
});
