<?php

namespace App\Http\Controllers;

use App\Models\iatacode;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IataCodeController extends Controller
{
    public function showIata()
    {
            $code=iatacode::get();
            if($code->isEmpty())
            {
             return response()->json(['success'=>0,'message' => 'No Data Found']);
            } 
            return response()->json(['success'=>1, 'Data' => $code]);
    }

    public function showAirport(Request $request)
    {
        try {
            // Retrieve the 'iata' query parameter from the request
            $params = $request->query('iata');
    
            // Validate that the IATA code is present
            if (!$params) {
                return response()->json([
                    'success' => 0,
                    'message' => 'IATA code is required'
                ], 400);
            }
    
            // Find the airport by IATA code
            $airport = iatacode::where('iata_code', $params)->first();
    
            // Check if the airport was found
            if (!$airport) {
                return response()->json([
                    'success' => 0,
                    'message' => 'No Data Found'
                ], 404);
            }
    
            // Return the airport name if found
            return response()->json([
                'success' => 1,
                'data' => $airport->airport_name
            ]);
    
        } catch (\Throwable $th) {
            // Handle any exceptions and return a JSON response
            return response()->json([
                'success' => 0,
                'error' => 'Something went wrong while retrieving data',
                'details' => $th->getMessage()
            ], 500);
        }
    }    
}