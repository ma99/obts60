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
    	$this->validate($request, [
            'city_name' => 'required|max:50',
            'division_name' => 'required|max:50'
            //'code' => 'required|max:25',
        ]);

    	//dd($request->input('city_id'));

    	$cityCode = $request->input('city_id');
    	$cityName = $request->input('city_name');
        $divisionName = $request->input('division_name');

        City::updateOrCreate(
            ['code' => $cityCode],
            ['name' => $cityName, 'division' => $divisionName]            
        );
    	return 'successfully added';
    }

    public function destroy(Request $request, City $city)
    {
       
        $error = ['error' => 'No results found'];
        // $cityCode = $request->input('city_code');
        // $city = City::where('code', $cityCode)->first();
        if($city) {
            $city->delete();
            return 'success';            
        }
        return $error;
    }
}
