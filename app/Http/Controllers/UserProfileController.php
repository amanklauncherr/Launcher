<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationConfirmation;
use App\Mail\UserResetPassword;

use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Support\Facades\Crypt;

class UserProfileController extends Controller
{
    //
    public function userRegister(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                'unique:users',
                'max:50',
                function ($attribute, $value, $fail) {
                    $validator = new EmailValidator();
                    if (!$validator->isValid($value, new RFCValidation())) {
                        $fail('The '.$attribute.' is invalid.');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ]
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
            return response()->json([
                'success' => 0,
                'error' => $formattedErrors[0]
            ], 422);
        }

        try {
            //code...
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // $token = JWTAuth::fromUser($user);
            $user->assignRole('user');
    
            if ($user) {
                UserVerification::create([
                    'userID'=>$user->id,
                    'uniqueCode'=> Str::random(100),
                    'verified' => 0,
                ]);              
                $code=UserVerification::where('userID',$user->id)->first();
                
                Mail::to($request->email)->send(new UserVerificationConfirmation($code->uniqueCode));
                return response()->json([
                    'success' => 1,
                    'message' => 'User registered successfully. Visit Your email to Verify',
                    'user' => $user,
                ], 201);
            }
             else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Failed to register user'
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => '0',
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

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
            return response()->json([
                'success' => 0,
                'error' => $formattedErrors[0]
            ], 422);
        }

            //code...
            $credentials = $request->only('email','password');
            $user = User::where('email',$credentials['email'])->first();
            
            if(!$user){
                return response()->json([ 'success' => 0,'error' => 'Email does not exist'], 404);
            }
            // $userVerified=UserVerification::where('userID',$user->id)->first();
            // if($userVerified->verified === 0)
            // {
            //     return response()->json([ 'success' => 0,'error' => 'Please Verify. Before Login'], 401);
            // }
            if(!Hash::check($credentials['password'],$user->password))
            {
                return response()->json([ 'success' => 0,'error' => 'Password does not match'], 401);
            }
            if (!$user->hasRole('user')) 
            {
                // User has the 'admin' role
                return response()->json([ 'success' => 0,'error' => 'Unauthorized Login Role. Only User can Login'], 401);  
            }    

        try {
                $token=Auth::guard('api')->login($user);
                return $this->respondWithToken($token);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => 0,
                'message' => 'Error while Login',
                'error' => $e->getMessage()
            ], 500);
        }
            //  //  to check roles
            // $roles = $user->getRoleNames();
            // print_r($roles->toArray());die();
            
            // $verificationStatus=UserVerification::where('userID',$user->id)->get();
            // if($verificationStatus[0]->verified === 1)
            // {
            // }
            // return response()->json([ 'success' => 0,'error' => 'Please Before login verify your registration by clicking on the link you have been sent on your'], 401);  


    }

    protected function respondWithToken($token){
        return response()->json([
            'success' => 1,
            'user'=>Auth::guard('api')->user(),
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->guard('api')->factory()->getTTL()*60,
            
        ]);
    }

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

            $tokenType = $request->attributes->get('token_type');
            if ($tokenType === 'public') {
                return response()->json(['Success'=> 0,'data' => 'Unauthorized, Login To Add Enquiry']);
            } elseif ($tokenType === 'user') {
                // $user = Auth::user();

            $user = $request->attributes->get('user');
            if(!Hash::check($credentials['old_password'],$user->password)){
                return response()->json(['error' => 'Old Password does not match'], 401);
            }
            if($credentials['new_password'] != $credentials['confirm_new_password']){
                return response()->json(['error' => 'Confirm New Password Should match with New Password '], 401);
            }

            $user->password = Hash::make($credentials['new_password']);

            $user->save();

            return response()->json(['message' => 'Password Updated Succcessfully'], 201);
            }

            return response()->json(['error' => 'Unauthorized'], 401);


        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error while Updating Admin Profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function AddUserProfile(Request $request)
    {
        $tokenType = $request->attributes->get('token_type');

        if ($tokenType === 'public') {
            return response()->json(['success'=> 0,'message' => 'Unauthorized, Login To Update Your Profile']);
        }
        elseif ($tokenType === 'user'){
            // $user = Auth::user();
            $user = $request->attributes->get('user');
            $userProfile= UserProfile::where('user_id',$user->id)->first();
            $validator = Validator::make($request->all(), [
                // 'last_name' => 'req'
                'user_Number' => $userProfile ? 'nullable|integer|unique:user_profiles,user_Number' : 'required|integer|unique:user_profiles,user_Number',
                'user_Address' => $userProfile ? 'nullable|string' : 'required|string',
                'user_City' => $userProfile ? 'nullable|string' : 'required|string',
                'user_State' => $userProfile ? 'nullable|string' : 'required|string',
                'user_Country' => $userProfile ? 'nullable|string' : 'required|string',
                'user_PinCode' => $userProfile ? 'nullable|string' : 'required|string',
                'user_AboutMe' => $userProfile ? 'nullable|string' :'required|string',
            ]);
        
            if ($validator->fails()) {
                $error=$validator->errors()->first();
                return response()->json([
                    "success" => 0,
                    'errors' => $error
                ], 422);
            }
        
            try {
                // $user = Auth::user();
                $profile = $request->only(['user_Number', 'user_Address', 'user_City', 'user_State', 'user_Country', 'user_PinCode', 'user_AboutMe']);             
                
                if($userProfile)
                {
                    // $user->name = $request->user_Name;
                    // $user->last_name = $re
                    $userProfile->update($profile);
                    $user->save();                    

                    return response()->json([
                        'success'=> 1,
                        'message' => 'Profile updated successfully','profile' => $userProfile,'user'=>$user
                    ], 201);
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

                    $userisProfile = User::where('id',$user->id)->first();

                    $userisProfile->update([
                        'isProfile' => true
                    ]);

                    return response()->json(['success'=>1, 'message' => 'Profile created successfully', 'profile' => $userProfile], 201);
                }
    
            } catch (\Exception $e) {
                return response()->json([
                    'success' => 0,
                    'message' => 'An error occurred while Creating User Profile',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        return response()->json(['success'=>0,'error' => 'Unauthorized.'], 401);
    }

    public function showUserProfile(Request $request)
    {
        try {
            //code...            
        $tokenType = $request->attributes->get('token_type');

        if ($tokenType === 'public') {
            return response()->json(['success'=> 0,'message' => 'Unauthorized, Login To Update Your Profile']);
        }
        elseif ($tokenType === 'user'){
            // $user=Auth::user();
            $user = $request->attributes->get('user');
            $id=$user->id;
            // return response()->json([$user->id]);
            $userProfile=UserProfile::where('user_id',$id)->first();
            if($user && $userProfile)
            {        
                return response()->json([
                    'success' =>1,
                    'user'=>$user,
                    'userprofile'=>$userProfile
                ],200);
            }            
            if($user && !$userProfile)
            {
                {        
                    return response()->json([
                        'success' => 1,
                        'user'=>$user,
                        'userprofile'=>'Please add your personal information in your profile'
                    ],200);
                }      
            }
        }
        return response()->json(['success'=>0,'error' => 'Unauthorized.'], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while Showing User data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function ResetPasswordEmail(Request $request)
    {
        $validator=Validator::make(request()->all(),[
            'email' => 'required|string',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => 0,
                'error' => $error 
            ], 422);
        }  

        $data=$validator->validated();

        $user = User::where('email', $data['email'])->first();
        
        if(!$user)
        {
            return response()->json(['success'=>0, 'error'=>'No User Exists with provided email'], 400);
        }
        if (!$user->hasRole('user')) 
        {
            return response()->json([ 'success' => 0,'error' => 'Unauthorized Email Role. Only User email can access'], 401);  
        }    
        try {

            $tokenData = [
                'email' => $data['email'],
                'created_at' => Carbon::now()->timestamp
            ];
            
            $encryptedToken =  Crypt::encryptString(json_encode($tokenData));

            Mail::to($data['email'])->send(new UserResetPassword($encryptedToken));
 
            return response()->json([
                'success' => 1,
                'message' => 'Mail Sent Successfully. Check Your mail'
            ], 200);
        

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred while Adding Email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ResetPassword(Request $request)
    {
        $validator=Validator::make(request()->all(),[
            "token" => 'required|string',
            "password" => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ]

        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => 0,
                'error' => $error 
            ], 422);
        }  

        try {

            //code...
            $data=$validator->validated();


            $decryptedTokenData = Crypt::decryptString($data['token']);
            $tokenData = json_decode($decryptedTokenData, true);
        
            $email = $tokenData['email'];
            $createdAt = Carbon::createFromTimestamp($tokenData['created_at']);
            
            // Set the expiration time (e.g., 5 minutes)
            $expirationTime = $createdAt->addMinutes(5);
        
            if (Carbon::now()->greaterThan($expirationTime)) {
                return response()->json(['success' => 0, 'error' => 'Your Link has Expired create a new one'], 400);
            }

            $user=User::where('email',$email)->first();

            if(!$user)
            {
                return response()->json(['success'=>0, 'error'=>'No User Exists with provided email'], 400);
            }
            if (!$user->hasRole('user')) 
            {
                // User has the 'admin' role
                return response()->json([ 'success' => 0,'error' => 'Unauthorized Email Role. Only User email can access'], 401);  
            }
            $user->update([
                'password' => Hash::make($data['password'])
            ]);

            return response()->json(['success'=>1, 'message'=> 'Password Updated Successfully'],200);
        } catch  (\Exception $e) {
                // Handle exception (e.g. network issues)
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
        }
    }

}
