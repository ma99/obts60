<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stop;

class StopController extends Controller
{
    public function store()
    {
    	
        //dd($request->input('stop_list'));
        //dd($request);

        // $this->validate($request, [            
        //     'stop_list.*.name' => 'required|max:50',       // array validation     
        // ]);

        // $stopList = $request->input('stop_list');    	
        //$cityCode = $request->input('city_id');
        $attributes = $this->validateRequest();
        //dd($attributes); 
        $stopList = $attributes['stop_list'];
        //dd($stopList);
        
        // foreach ($stopList as $stop) {                
        //    Stop::updateOrCreate(
        //         ['city_id' => $stop['city_id'], 'name' => $stop['name'] ],
        //         ['name' => $stop['name']]            
        //     );
        // }
        //Stop::insert($stopList);
        Stop::insert($attributes['stop_list']);
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

    protected function validateRequest()
    {
        return request()->validate([
           'stop_list.*.*' => 'required',       // array validation                
        ]);
    }
}
