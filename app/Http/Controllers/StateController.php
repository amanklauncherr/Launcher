<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\state;
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

}
