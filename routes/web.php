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

	//schedule 
	Route::post('/schedules', 'Admin\ScheduleController@store')->name('schedule');

	//bus route
	Route::post('/bus-route/{bus}', 'Admin\BusRouteController@store');
	Route::delete('/bus-route/{bus}/{route}', 'Admin\BusRouteController@destroy');
	//Route::post('/routes/{route}', 'Admin\RouteController@addBusesForRoute');

	//bus schedule
	Route::post('/bus-schedule/{bus}', 'Admin\BusScheduleController@store');
//});	

Route::group(['middleware' => ['auth']], function () {
	// booking
	Route::post('/bookings', 'BookingController@store');
	Route::delete('/bookings/{booking}', 'BookingController@destroy');
    
});

Route::get('/search', 'SearchTicketController@searchTicket');
Route::get('/viewseats/buses/{bus}', 'SearchTicketController@viewSeats');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sp', function() {
	// DB::listen(function($query){
 //        	dump($query->sql);
 //        });

        //$seatPlan = SeatPlan::latest()->get();
        $seatPlan = App\SeatPlan::cursor();
        dump($seatPlan);

        return 'Done';
});