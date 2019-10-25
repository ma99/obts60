<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//city
Route::post('/cities', 'Admin\CityController@store');
Route::delete('/cities/{city}', 'Admin\CityController@destroy');

//stop
Route::post('/stops', 'Admin\StopController@store');
Route::delete('/stops/{stop}', 'Admin\StopController@destroy');

//route
Route::post('/routes', 'Admin\RouteController@store');
Route::delete('/routes/{route}', 'Admin\RouteController@destroy');

//fare
Route::patch('/fares/{fare}', 'Admin\FareController@update');
//Route::post('/fares', 'Admin\FareController@store');
