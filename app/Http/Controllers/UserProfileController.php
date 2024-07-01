<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserProfileController extends Controller
{
    //
    public function userRegister(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:50',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ]
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            //code...
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = JWTAuth::fromUser($user);
            $user->assignRole('user');
    
            return response()->json(compact('user','token'), 201);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error while Register',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function userLogin(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email' => 'required|email|max:50',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try {
            //code...
            $credentials = $request->only('email','password');
            $user = User::where('email',$credentials['email'])->first();
            
            if(!$token=Auth::guard('api')->attempt($credentials)){
                if(!$user){
                    return response()->json(['error' => 'Email does not exist'], 404);
                }
                if(!Hash::check($credentials['password'],$user->password))
                {
                    return response()->json(['error' => 'Password does not match'], 401);
                }

                return response()->json(['error'=>'Unauthorized User'],401);
            }
              //  to check roles
            // $roles = $user->getRoleNames();
            // print_r($roles->toArray());die();

            // Role Login Condition
            if (!$user->hasRole('user')) 
            {
                // User has the 'admin' role
                return response()->json(['error' => 'Unauthorized Login Role. Only User can Login'], 401);  
            }
            return $this->respondWithToken($token);
        }  catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error while Login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function respondWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->guard('api')->factory()->getTTL()*60,
            'user'=>Auth::guard('api')->user(),
        ]);
    }

    // public function updateUserProfile(Request $request){
        
    // }

    public function passwordUpdateUser(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'old_password'=>'required|string|min:8',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
            'confirm_new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
        ]);

        if($validator->fails())
        {
           return response()->json(['errors' => $validator->errors()], 422);   
        }

        try {
            //code...
            $credentials = $request->only('old_password', 'new_password','confirm_new_password');
            $user = Auth::user();

            // if (!$user->hasRole('user')) 
            // {
            //     // User has the 'admin' role
            //     return response()->json(['error' => 'Unauthorized Login Role. Only User can Login'], 401);  
            // }
            // $oldPass=$user->password

            if(!Hash::check($credentials['old_password'],$user->password)){
                return response()->json(['error' => 'Old Password does not match'], 401);
            }
            if($credentials['new_password'] != $credentials['confirm_new_password']){
                return response()->json(['error' => 'Confirm New Password Should match with New Password '], 401);
            }

            $user->password = Hash::make($credentials['new_password']);

            $user->save();

            return response()->json(['message' => 'Password Updated Succcessfully'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error while Updating Admin Profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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
