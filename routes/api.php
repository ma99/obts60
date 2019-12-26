<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/search', [
//     'as' => 'api.search',
//     'uses' => 'Api\SearchController@search'
// ]);

//bus
//Route::get('/bus', 'Api\SearchBusController@busInfo');
Route::get('/buses', 'Api\SearchBusController@busList');
Route::get('/routes', 'Api\SearchBusController@routeList');
Route::get('/stops', 'Api\SearchBusController@stopList');

//schedule
Route::get('/schedule', 'Api\SearchScheduleController@scheduleList');

//seat plan
Route::get('/seatplans', 'Api\SearchSeatPlanController@seatPlanList');

//city
Route::get('/city', 'Api\SearchCitiesController@cityTo');
Route::get('/divisions', 'Api\SearchCitiesController@divisionList');
Route::get('/districts', 'Api\SearchCitiesController@districtList');
Route::get('/cities', 'Api\SearchCitiesController@cityList');
Route::get('/pickup', 'Api\SearchCitiesController@pickupPoints');
Route::get('/dropping', 'Api\SearchCitiesController@droppingPoints');


//Route::get('/test', 'Api\SearchCitiesController@index');
Route::get('/testapi', 'Api\SearchCitiesController@testApi');
Route::get('/zipcode', 'Api\SearchCitiesController@cityName');
//Route::get('/pay/{booking}', 'Api\SearchCitiesController@makeMyPayment');
//Route::get('/pay', 'Payment\PaymentController@payNow')->name('payment');
// Route::post('/payment/success', 'Payment\PaymentController@success');
// Route::post('/payment/fail}', 'Payment\PaymentController@fail');