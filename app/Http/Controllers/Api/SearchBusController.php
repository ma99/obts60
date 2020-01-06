<?php

namespace App\Http\Controllers\Api;

//use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Bus;
use App\Rout;
use App\Stop;


class SearchBusController extends Controller
{
   
   protected $request;

   public function __construct(Request $request)
   {
        $this->request = $request;  
   } 
   

   // public function busInfo()
   // {
   //      //$city_name = $request->input('name');
   //      //$city_name= 'dhaka';
   //      $error = ['error' => 'No results found'];
        
	  //     $busId = $this->request->input('q');
   //        $busInfo = Bus::where('id', $busId)->first(); 

   //        //$array = json_decode(json_encode($object), true);  // object to array          
         
   //        return ($busInfo == null) ? $error : $busInfo;
   // }

   public function busList()
   {
        
        $error = ['error' => 'No results found'];

        //$buses = $bus->getBusesWithSeatPlan();
        $buses = Bus::with('seat_plan')->get();

        foreach ($buses as $bus) {           
            $busList[] = [
                'bus'   => $bus,
                'total_seats' => $bus->seat_plan->total_seats
            ];
        }        
        
        return count($busList) ? $busList : $error;       
   }

   public function routeList()
   {
        $error = ['error' => 'Route Not Found']; 

        //$divisionId = $this->request->input('q');
        //$routes = Rout::all();
        //$routes = Rout::all();
        $routes = Rout::with('fare')->get();
        return $routes->count() ? $routes : $error;
   }   


   public function stopList()
   {
        $error = ['error' => 'Stop Not Found']; 
        
        $stops = Stop::all();
        return $stops->count() ? $stops : $error;
   }
}
