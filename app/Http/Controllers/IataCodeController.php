<?php

namespace App\Http\Controllers;

use App\Models\iatacode;
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
}