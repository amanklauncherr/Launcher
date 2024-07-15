<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CountryCode;

class CountryCodeController extends Controller
{
    //

    public function showCountryCode(){
       $code=CountryCode::get();
       if($code->isEmpty())
       {
        return response()->json(['success'=>0,'message' => 'No Country Code Found']);
       } 
       
       $codes=$code->map(function($C){
        return $C['country_code'];
       });
       return response()->json(['success'=>1, 'Codes' => $codes]);
    }
}
