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
   public function index()
   {        
        $error = ['error' => 'No results found'];

        $buses = Bus::with('seat_plan')->get();

        foreach ($buses as $bus) {           
            $busList[] = [
                'bus'   => $bus,
                'total_seats' => $bus->seat_plan->total_seats
            ];
        }        
        
        return count($busList) ? $busList : $error;       
   } 

   public function stopList()
   {
        $error = ['error' => 'Stop Not Found']; 
        
        $stops = Stop::all();
        return $stops->count() ? $stops : $error;
   }
}
