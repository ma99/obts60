<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;
use App\Division;
use App\District;
use App\Fare;
use App\Route;
use App\Stop;

class SearchCitiesController extends Controller
{
  public function index()
   {
    $error = ['error' => 'City Not Found for Bus Service'];     
    $cities = City::all();
    return $cities->count() ? $cities : $error;
   } 

   public function routeCities(Route $route)
   {
     return $route->cities;
   }

   public function cityTo()
   {
        //$city_name = $request->input('name');
        //$city_name= 'dhaka';
        $error = ['error' => 'No results found'];
        
	        $city_name = $this->request->input('q');
	        $cities = Rout::where('departure_city', $city_name)->get();
	       // dd($cities);
	        return $cities->count() ? $cities : $error;
	        //return $cities;       
   }

   public function pickupPoints()
   {
        //$city_name = $request->input('name');
        //$city_name= 'dhaka';
        $error = ['error' => 'No results found'];
        
          $cityName = $this->request->input('q');
          // $city = City::where('name', $city_name)->first();
          // $cityId = $city->id;
          $cityId = $this->findCityCodeByCityName($cityName);

          $stops = Stop::where('city_id', $cityId)->get();
         // dd($cities);
          return $stops->count() ? $stops : $error;
          //return $cities;
       
   }

   public function droppingPoints()
   {
        $error = ['error' => 'No results found'];

        $cityName = $this->request->input('q');      

        $cityId = $this->findCityCodeByCityName($cityName);

        $stops = Stop::where('city_id', $cityId)->get();
        // dd($cities);
        return $stops->count() ? $stops : $error;
        //$city = $cityName.'/'.$cityId
        //return $city;
   }

   public function findCityCodeByCityName($cityName)
   {
      $city = City::where('name', $cityName)->first();
      return $city->code;
   }
   
}
