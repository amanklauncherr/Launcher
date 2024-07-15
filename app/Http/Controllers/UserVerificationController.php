<?php

namespace App\Http\Controllers;

use App\Models\UserVerification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    //
    public function verify(Request $request,$uniqueCode){
        $userVerified=UserVerification::where('uniqueCode',$uniqueCode)->first();
        if (!$userVerified) {
            return response()->json(['success' => 0, 'message' => 'Not Found'], 401);
        }
        
        $userVerified->verified = 1;
        $userVerified->save();
    
        return response()->json(['success' => 1, 'message' => 'User successfully verified']);
    }
}
