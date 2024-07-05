<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cites;
use Illuminate\Http\Request;

class CitesController extends Controller
{
    //
    public function Cites(Request $request){
        
        // Retrieve all cities
        $cities = Cites::all();

        $cityArray = [];
        foreach($cities as $city)
        {
            $cityArray[] = $city->city;
        }
        
        sort($cityArray);
        return response()->json($cityArray,200);
    }   
}
