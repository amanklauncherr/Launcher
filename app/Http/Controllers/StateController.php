<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\state;
use App\Models\Cites;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\State as PhpunitState;

class StateController extends Controller
{

    public function AddStates(Request $request)
    {

        $json='[
                {
                "code": "AN",
                "name": "Andaman and Nicobar Islands"
                },
                {
                "code": "AP",
                "name": "Andhra Pradesh"
                },
                {
                "code": "AR",
                "name": "Arunachal Pradesh"
                },
                {
                "code": "AS",
                "name": "Assam"
                },
                {
                "code": "BR",
                "name": "Bihar"
                },
                {
                "code": "CG",
                "name": "Chandigarh"
                },
                {
                "code": "CH",
                "name": "Chhattisgarh"
                },
                {
                "code": "DH",
                "name": "Dadra and Nagar Haveli"
                },
                {
                "code": "DD",
                "name": "Daman and Diu"
                },
                {
                "code": "DL",
                "name": "Delhi"
                },
                {
                "code": "GA",
                "name": "Goa"
                },
                {
                "code": "GJ",
                "name": "Gujarat"
                },
                {
                "code": "HR",
                "name": "Haryana"
                },
                {
                "code": "HP",
                "name": "Himachal Pradesh"
                },
                {
                "code": "JK",
                "name": "Jammu and Kashmir"
                },
                {
                "code": "JH",
                "name": "Jharkhand"
                },
                {
                "code": "KA",
                "name": "Karnataka"
                },
                {
                "code": "KL",
                "name": "Kerala"
                },
                {
                "code": "LD",
                "name": "Lakshadweep"
                },
                {
                "code": "MP",
                "name": "Madhya Pradesh"
                },
                {
                "code": "MH",
                "name": "Maharashtra"
                },
                {
                "code": "MN",
                "name": "Manipur"
                },
                {
                "code": "ML",
                "name": "Meghalaya"
                },
                {
                "code": "MZ",
                "name": "Mizoram"
                },
                {
                "code": "NL",
                "name": "Nagaland"
                },
                {
                "code": "OR",
                "name": "Odisha"
                },
                {
                "code": "PY",
                "name": "Puducherry"
                },
                {
                "code": "PB",
                "name": "Punjab"
                },
                {
                "code": "RJ",
                "name": "Rajasthan"
                },
                {
                "code": "SK",
                "name": "Sikkim"
                },
                {
                "code": "TN",
                "name": "Tamil Nadu"
                },
                {
                "code": "TS",
                "name": "Telangana"
                },
                {
                "code": "TR",
                "name": "Tripura"
                },
                {
                "code": "UP",
                "name": "Uttar Pradesh"
                },
                {
                "code": "UK",
                "name": "Uttarakhand"
                },
                {
                "code": "WB",
                "name": "West Bengal"
                }
                ]';

        $States = json_decode($json,true);
        
        $collection = collect($States);

        // Map through the collection to extract name and callingCode
        $AddStates = $collection->map(function ($States) {
            return [
                'state' => $States['name'],
            ];
        });
    
        // Insert the mapped data into the country_codes table
        State::insert($AddStates->toArray());
    
        return response()->json(['message' => 'States inserted successfully']);


    } 

    /**
     * @group State&City&Iata
     *
     * API to retrieve a list of all states.
     *
     * @response 200 {
     *   "success": 1,
     *   "states": ["California", "Texas", "New York", "Florida", ...]
     * }
     *
     * @response 404 {
     *   "success": 0,
     *   "message": "No State Found"
     * }
     */

    public function showState()
    {
        $state=state::get();
        if($state->isEmpty())
        {
            return response()->json(['success'=>0,'message'=>'No State Found'],404);
        }
        $s=$state->pluck('state');
        return response()->json(['success'=>1,'states'=>$s],200);
    }

    /**
     * @group State&City&Iata
     *
     * API to retrieve unique states from the cities data.
     *
     * @response 200 {
     *   "success": 1,
     *   "states": ["California", "Texas", "New York", "Florida", ...]
     * }
     *
     * @response 404 {
     *   "success": 0,
     *   "message": "No State Found"
     * }
     */

    public function AllState()
    {
        $states = Cites::distinct()->pluck('state');

        if ($states->isEmpty()) {
            return response()->json(['success' => 0, 'message' => 'No State Found'], 404);
        }

        return response()->json(['success' => 1, 'states' => $states], 200);
    }

    /**
     * @group State&City&Iata
     *
     * API to retrieve a list of cities for a specific state.
     *
     * @queryParam state required The name of the state to filter cities by.
     *
     * @response 200 {
     *   "success": 1,
     *   "Cities": ["Los Angeles", "San Francisco", "San Diego", ...]
     * }
     *
     * @response 404 {
     *   "success": 0,
     *   "message": "Please Select A State"
     * }
     *
     * @response 404 {
     *   "success": 0,
     *   "message": "No State Found"
     * }
     */


    public function CITIES(Request $request)
    {
        $state=$request->query('state');
        if(!$state)
        {
            return response()->json(['success' => 0, 'message' => 'Please Select A State'], 404);
        }

        $cities = Cites::where('state',$state)->get()->pluck('city');
        if ($cities->isEmpty()) {
            return response()->json(['success' => 0, 'message' => 'No State Found'], 404);
        }
        return response()->json(['success' => 1, 'Cities' => $cities], 200);
    }

}
