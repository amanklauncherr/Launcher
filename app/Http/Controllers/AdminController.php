<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class AdminController extends Controller
{   
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
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
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = JWTAuth::fromUser($admin);
            $admin->assignRole('admin');
    
            return response()->json(compact('admin'), 201);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error while Register',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'email'=>'required|email',
            'password'=>[
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                // $user = User::where('email', $credentials['email'])->first();
              

                if (!$user) {
                    return response()->json(['error' => 'Email does not exist'], 404);
                }

                // Check if the password matches
                if (!Hash::check($credentials['password'], $user->password)) {
                    return response()->json(['error' => 'Password does not match'], 401);
                }

                // If the above checks are passed but authentication fails
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //  to check roles
            // $roles = $user->getRoleNames();
            // print_r($roles->toArray());die();
            // $user = User::find($userId);

            // Role Login Condition
            if (!$user->hasRole('admin')) 
            {
                // User has the 'admin' role
                return response()->json(['error' => 'Unauthorized Login Role. Only Admin can Login'], 401);  
            }
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
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
            // 'refresh_token' => $this->createRefreshToken(),
        ], 200);
    }

    // public function refresh()
    // {
    //     return $this->respondWithToken(JWTAuth::refresh());
    // }

    // protected function createRefreshToken() {
    //     // $customClaims = ['type' => 'refresh'];
      
    //     try {
    //     // $refreshToken = JWTAuth::customClaims($customClaims)
    //     //     ->setTTLMinutes(config('jwt.refresh_ttl'))
    //     //     ->fromUser(auth()->user());
      
    //     //   return $refreshToken;

    //     $customClaims = [
    //         'type' => 'refresh',
    //         'exp' => now()->addMinutes(config('jwt.refresh_ttl'))->timestamp
    //     ];
    //     return JWTAuth::claims($customClaims)->fromUser(auth()->user());

    //     } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    //       report($e); // Report the exception for logging or debugging
      
    //       return response()->json([
    //         'message' => 'Error generating refresh token',
    //         'error' => $e->getMessage(), // Consider providing a more generic message for security reasons
    //       ], 500);
    //     }
    //   }

    public function allUser()
    {
        $users= User::all();      
        if($users->isEmpty())
        {
            return response()->json(['error' => 'not found'], 404);
        }
        return response()->json(['message'=>$users]);
    }
    

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'nullable|string|max:50',
            'email'=>'nullable|email|unique:users,email'.Auth::id(),
            'password'=>[
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            //code...
            $user=Auth::user();

            if ($request->filled('name')) {
                $user->name = $request->name;
            }
    
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
    
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            $user->save();

            return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        }catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error while Updating Admin Profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}


    // try {
    //     // Extract the refresh token from the Authorization header
    //     $authHeader = $request->header('Authorization');
    //     if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
    //         return response()->json(['error' => 'Refresh token not provided'], 400);
    //     }

    //     $refreshToken = str_replace('Bearer ', '', $authHeader);

    //     // Pass the refresh token to the JWTAuth::refresh() method
    //     $newToken = JWTAuth::setToken($refreshToken)->refresh();

    //     return $this->respondWithToken($newToken);
    // } catch (JWTException $e) {
    //     return response()->json(['error' => 'Could not refresh token'], 500);
    // }
    
    // protected function createRefreshToken(){
    //     // return JWTAuth::claims(['type' => 'refresh'])->attempt(['email' => JWTAuth::user()->email, 'password' =>'']);

    //     // $customClaims = ['type' => 'refresh'];
    //     // return JWTAuth::customClaims($customClaims)->fromUser(auth()->user());

    //     $customClaims = ['type' => 'refresh'];
    //     $refreshToken = JWTAuth::customClaims($customClaims)
    //         ->setTTL(config('jwt.refresh_ttl'))
    //         ->fromUser(auth()->user());
    
    //     return $refreshToken;
    // }
