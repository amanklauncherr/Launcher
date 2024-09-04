<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\state;
use App\Models\Cites;
use Illuminate\Http\Request;

class StateController extends Controller
{
    //
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

    public function AllState()
    {
        // Fetch unique states directly from the database
        $states = Cites::distinct()->pluck('state');

        if ($states->isEmpty()) {
            return response()->json(['success' => 0, 'message' => 'No State Found'], 404);
        }

        return response()->json(['success' => 1, 'states' => $states], 200);
    }

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
