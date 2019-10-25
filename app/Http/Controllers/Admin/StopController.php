<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stop;

class StopController extends Controller
{
    public function store(Request $request)
    {
    	
        //dd($request->input('stop_list'));
        //dd($request);

        $this->validate($request, [            
            'stop_list.*.name' => 'required|max:50',       // array validation     
        ]);

        $stopList = $request->input('stop_list');    	
        //$cityCode = $request->input('city_id');

        
        foreach ($stopList as $stop) {                
           Stop::updateOrCreate(
                ['city_id' => $stop['city_id'], 'name' => $stop['name'] ],
                ['name' => $stop['name']]            
            );
        }
    	return 'successfully added';
    }

    public function destroy(Stop $stop)
    {
        $error = ['error' => 'No results found'];
        
        if($stop) {
            $stop->delete();
            return 'success';            
        }
        return $error;
    }
}
