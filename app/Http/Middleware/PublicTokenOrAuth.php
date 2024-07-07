<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class PublicTokenOrAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $publicToken = env('PUBLIC_TOKEN','WlDEZA0QpYffLXRRjPTaAwE83YImK4JE5utDP91fBpmbyiBIvejCRWmDMuYpm4xIYYJU2muY9aQql6RiYY7khCS9BPOW8ra8ezTHyX1pQcYhtOd5b5ZT2fkuHxwazFSdlYBqlVByqaz72jRhLJx5x7J7dolhLGGo28fTklfQwq77cwDu0QBLkiAUAWwX10abith47P3xrA9sL2DH9kra14X9w6JRae36PpbycXg1uhoXvIMOzpqHHDUyto6');
        if ($request->header('Authorization') === 'Bearer ' . $publicToken) {
                        // Add a flag to the request indicating it is a public request
                        $request->attributes->set('token_type', 'public');
                        return $next($request);
        }
        try {
                        if ($user = JWTAuth::parseToken()->authenticate()) {
                            // Add a flag to the request indicating it is a user request
                            $request->attributes->set('token_type', 'user');
                            $request->attributes->set('user', $user);
                            return $next($request);
                        }
                    } catch (\Exception $e) {
                        // Do nothing, will return unauthorized below
                    }
            
                    // If neither token is valid, return unauthorized response
                    return response()->json(['error' => 'Unauthorized'], 401);

    }
}

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Tymon\JWTAuth\Facades\JWTAuth;

// class PublicTokenMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Define your public token
//         $publicToken = env('PUBLIC_TOKEN', 'your-public-token');

//         // Check if the token matches the public token
//         if ($request->header('Authorization') === 'Bearer ' . $publicToken) {
//             // Add a flag to the request indicating it is a public request
//             $request->attributes->set('token_type', 'public');
//             return $next($request);
//         }

//         // Check if the token matches a user token
//         try {
//             if ($user = JWTAuth::parseToken()->authenticate()) {
//                 // Add a flag to the request indicating it is a user request
//                 $request->attributes->set('token_type', 'user');
//                 $request->attributes->set('user', $user);
//                 return $next($request);
//             }
//         } catch (\Exception $e) {
//             // Do nothing, will return unauthorized below
//         }

//         // If neither token is valid, return unauthorized response
//         return response()->json(['error' => 'Unauthorized'], 401);
//     }
// }