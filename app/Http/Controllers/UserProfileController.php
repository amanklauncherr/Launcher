<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    //
    public function AddProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_Number' => 'nullable|integer',
            'user_Address' => 'required|string',
            'user_City' => 'required|string',
            'user_State' => 'required|string',
            'user_Country' => 'required|string',
            'user_PinCode' => 'required|string',
            'user_AboutMe' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $user = Auth::user();
            $profile = $request->only(['user_Number', 'user_Address', 'user_City', 'user_State', 'user_Country', 'user_PinCode', 'user_AboutMe']);

            $userProfile= UserProfile::where('user_id',$user->id)->first();
             
            if($userProfile)
            {
                $userProfile->update($profile);
            }
            else{
                $userProfile = UserProfile::create([
                    'user_id' => $user->id,
                    'user_Number' => $profile['user_Number'],
                    'user_Address' => $profile['user_Address'],
                    'user_City' => $profile['user_City'],
                    'user_State' => $profile['user_State'],
                    'user_Country' => $profile['user_Country'],
                    'user_PinCode' => $profile['user_PinCode'],
                    'user_AboutMe' => $profile['user_AboutMe']
                ]);
            }
            return response()->json($userProfile, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while Creating User Profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showUserProfile()
    {
        try {
            //code...
            $user=Auth::user();
            $userProfile=UserProfile::where('user_id',$user->id)->first();
            if($userProfile)
            {        
                return response()->json(['userprofile'=>$userProfile],200);
            }
            return response()->json(['No User Profile found'],404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while Creating User Profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
