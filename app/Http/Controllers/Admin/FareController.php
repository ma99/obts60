<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Fare;

class FareController extends Controller
{
    
	protected $request;
	
	public function __construct(Request $request)
	{   
	    $this->request = $request;
	    //$this->middleware(['auth', 'admin']);
	}

    public function update(Fare $fare)
    {
        //$routeId = $this->request->input('route_id');
        $fareDetails = $this->request->input('fare');

        /*Fare::updateOrCreate(
            ['rout_id' => $routeId],
            ['details' => $fareDetails]
        );*/
 
        $fare->update([
        	'details' => $fareDetails 
        ]);

        return 'success';
    }
}