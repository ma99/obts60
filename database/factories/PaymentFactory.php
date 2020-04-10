<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'booking_id' => factory('App\Booking'),
        'transaction_id' => uniqid(),
		'amount'	=> 800,
		'currency'	=> 'BDT',
		'method' => 'card',
		//'payment_data'	=> ($paymentMethod == 'card') ? $data : null,
		'status' => 'Pending',      
    ];
});
