<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    public function store(Request $request)
    {
    	//dd($request->input('city_id'));
    	// $this->validate($request, [
     //        'city_name' => 'required|max:50',
     //        'division_name' => 'required|max:50'
     //        //'code' => 'required|max:25',
     //    ]);
        $attributes = $this->validateRequest();

    	//dd($request->input('city_id'));

    	// $cityCode = $request->input('city_id');
    	// $cityName = $request->input('city_name');
     //    $divisionName = $request->input('division_name');

        City::updateOrCreate(
            ['district_id' => $attributes['district_id']],
            ['name' => $attributes['name']]            
        );
    	return 'successfully added';
    }

    public function destroy(City $city)
    {        
        $city->delete();
        return 'deleted';                    
    }

    protected function validateRequest()
    {
        return request()->validate([
           'district_id' => 'required',
           'name'  => 'required'
        ]);
    }
}
