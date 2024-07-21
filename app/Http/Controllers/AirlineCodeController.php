<?php

namespace App\Http\Controllers;

use App\Models\AirlineCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;

class AirlineCodeController extends Controller
{
public function showAirlineCode(Request $request)
{
    try {
        // Retrieve the 'iata' query parameter from the request
        $params = $request->query('code');

        // Validate that the IATA code is present
        if (!$params) {
            return response()->json([
                'success' => 0,
                'message' => 'Airline code is required'
            ], 400);
        }

        // Find the airport by IATA code
        $airport = AirlineCode::where('carrier_code', $params)->get();

        // Check if the airport was found
        if ($airport->isEmpty()) {
            return response()->json([
                'success' => 0,
                'message' => 'No Data Found'
            ], 404);
        }

        // Return the airport name if found
        return response()->json([
            'success' => 1,
            'data' => $airport[0]
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
