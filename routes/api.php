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
Route::get('/buses', 'Api\SearchBusesController@index');
Route::get('/types', 'Api\SearchTypesController@index');
Route::get('/routes', 'Api\SearchRoutesController@index');
Route::get('/fares', 'Api\SearchFaresController@index');
Route::get('/stops', 'Api\SearchStopsController@index');

//schedule
Route::get('/schedule', 'Api\SearchScheduleController@index');

//seat plan
Route::get('/seatplans', 'Api\SearchSeatPlanController@index');

Route::get('/divisions', 'Api\SearchDivisionsController@index');
Route::get('/districts', 'Api\SearchDistrictsController@index');
Route::get('/upazilas', 'Api\SearchUpazilasController@index');
Route::get('/cities', 'Api\SearchCitiesController@index');
Route::get('/{route}/cities', 'Api\SearchCitiesController@routeCities');

//city

Route::get('/city', 'Api\SearchCitiesController@cityTo');
Route::get('/pickup', 'Api\SearchCitiesController@pickupPoints');
Route::get('/dropping', 'Api\SearchCitiesController@droppingPoints');


//Route::get('/test', 'Api\SearchCitiesController@index');
Route::get('/testapi', 'Api\SearchCitiesController@testApi');
Route::get('/zipcode', 'Api\SearchCitiesController@cityName');
//Route::get('/pay/{booking}', 'Api\SearchCitiesController@makeMyPayment');
//Route::get('/pay', 'Payment\PaymentController@payNow')->name('payment');
// Route::post('/payment/success', 'Payment\PaymentController@success');
// Route::post('/payment/fail}', 'Payment\PaymentController@fail');