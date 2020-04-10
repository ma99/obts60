<?php

Route::get('/', function () {
	
    return view('welcome');
});

Route::get('admin/{vue?}', function () {
    return view('admin.admin');
})->where('vue', '[\/\w\.-]*');//->middleware('auth', 'role:super_admin,admin');

Route::group(['middleware' => ['auth', 'role:super_admin']], function () {	
	//Route::delete('/bookings/{booking}', 'BookingController@destroy');    
	Route::post('/users/{user}/roles/{role}', 'Admin\Super\UserRoleController@store');
});

//Route::group(['middleware' => ['auth', 'role:super_admin,admin']], function () {
	
	//bus
	//Route::get('/bus/ids', 'Admin\BusController@busIds');
	//Route::get('/bus/{id}', 'Admin\BusController@showSeat');
	//Route::post('/bus/seatplan', 'Admin\BusController@storeSeatPlan');
	Route::post('/buses', 'Admin\BusController@store');
	Route::patch('/buses/{bus}', 'Admin\BusController@update');
	Route::delete('/buses/{bus}', 'Admin\BusController@destroy');

	//city
	Route::post('/cities', 'Admin\CityController@store');
	Route::delete('/cities/{city}', 'Admin\CityController@destroy');

	//stop
	Route::post('/stops', 'Admin\StopController@store');
	Route::delete('/stops/{stop}', 'Admin\StopController@destroy');

	//seat plan
	Route::post('/seatplans', 'Admin\SeatPlanController@store');
	Route::delete('/seatplans/{seatplan}', 'Admin\SeatPlanController@destroy');

	//route
	Route::post('/routes', 'Admin\RouteController@store');
	Route::patch('/routes/{route}', 'Admin\RouteController@update');
	Route::delete('/routes/{route}', 'Admin\RouteController@destroy');

	//fare
	Route::post('/fares', 'Admin\FareController@store');
	Route::patch('/fares/{fare}', 'Admin\FareController@update');
	Route::delete('/fares/{fare}', 'Admin\FareController@destroy');

	//schedule 
	Route::post('/schedules', 'Admin\ScheduleController@store')->name('schedule');

	//bus route
	Route::post('/bus-route/{bus}', 'Admin\BusRouteController@store');
	Route::delete('/bus-route/{bus}/{route}', 'Admin\BusRouteController@destroy');
	//Route::post('/routes/{route}', 'Admin\RouteController@addBusesForRoute');

	//bus schedule
	Route::post('/bus-schedule/{bus}', 'Admin\BusScheduleController@store');
//});	

Route::group(['middleware' => ['auth', 'role:super_admin,admin,operator']], function () {
	Route::get('/users/{phone}', 'Admin\UserController@index');
	Route::post('/bookings/byStaff/{user?}', 'BookingController@createByStaff');
	Route::post('/pay/cash', 'Payment\PaymentController@cash')->name('make.payment.cash');
});
Route::group(['middleware' => ['auth']], function () {
	// booking
	Route::post('/bookings', 'BookingController@store');
	Route::delete('/bookings/{booking}', 'BookingController@destroy');
    
});

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'SearchTicketController@index')->name('home');//->middleware('verifiedphone'); 
Route::get('/search', 'SearchTicketController@searchTicket');
Route::get('/viewseats/buses/{bus}', 'SearchTicketController@viewSeats');

/** Phone Verification */
Route::get('phone/verify', 'PhoneVerificationController@show')->name('phoneverification.notice');
Route::post('phone/verify', 'PhoneVerificationController@verify')->name('phoneverification.verify');
Route::post('phone/resend', 'PhoneVerificationController@resend')->name('phoneverification.resend');

/*Payment*/
//Route::post('/pay/{booking}', 'Payment\PaymentController@index')->name('make.payment');
//Route::post('/pay', 'Payment\PaymentController@cash')->name('make.payment.cash'); //shifted to admin grps
Route::post('/pay/card', 'Payment\PaymentController@card')->name('make.payment.card');
Route::post('/payment/success', 'Payment\PaymentController@success');
Route::post('/payment/fail', 'Payment\PaymentController@fail');
Route::post('/payment/cancel', 'Payment\PaymentController@cancel');
Route::post('/payment/ipn', 'Payment\PaymentController@ipn');
 
Auth::routes();


Route::get('/sp', function() {
	// DB::listen(function($query){
 //        	dump($query->sql);
 //        });

        // //$seatPlan = SeatPlan::latest()->get();
        // $seatPlan = App\SeatPlan::cursor();
        // dump($seatPlan);
	$password = Hash::make(Str::random(8)); 
	$attributes = [
		'name' => 'aauuvvuu',          
        'email' => 'mmn@a.com',          
        'phone' => '77888888888',
    	'password' => $password,
        ];          
	return $user = auth()->user()->create($attributes);
	dd($user);
        // return 'Done';
	$msg = "Completed Successfuly";
	//view('payment.status', compact($msg));
	$options = [
                'border' => 'border-success',
                'button' => 'success',
                'msg' => $msg,
                'icon' => 'fa-check-circle',
                //'icon' => 'fa-times-circle',
                //'color' => 'success'
                'status' => 'success',
                'title' => 'Thank You!'
            ];
	return view('payment.status', $options);
});
$options = [
	'border' => 'border-danger',
	'button' => 'warning',
	'msg' => 'mmmm',
	//'icon' => 'fa-check-circle',
	'icon' => 'fa-times-circle',
	//'color' => 'success'
	'status' => 'error',
	'title' => 'Oops!'
];
Route::view('/pay101', 'payment.status', $options);