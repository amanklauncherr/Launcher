<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Payload;

class AESEncryption extends Controller
{
    //
    function encryptToken($token, $key)
    {
        $iv = '22f632f1d31cc2de';

        $encryptedToken = openssl_encrypt($token, 'AES-256-CBC', $key, 0, $iv);

        // return base64_encode($iv . $encryptedToken); // Concatenate IV with the encrypted token
        return $encryptedToken;
    }

    public function AESEncryption(Request $request)
    {
        $payload = [
            'mobileNumber' => '9871831224',
            'password' => 'Launcherr2024@!'
        ];

        // Make the HTTP POST request
        $response = Http::post('https://api.dotmik.in/api/user/v1/generate/token', $payload);

        // return $payload;
        // dd($payload);
    
        // Check if the request was successful
        if ($response->successful()) {
            // Return or process the response
            $result =  $response->json();

            $token = $result['payloads']['data']['token'];
            $key = $result['payloads']['data']['key'];

            $encryptionKey = '54c3ac7333fd510b2512a475d4d2bef2';

            $encryptedToken = $this->encryptToken($token, $encryptionKey);

            $encryptedKey = $this->encryptToken($key, $encryptionKey);

            return response()->json([
                'success' => true,
                'encrypted_token' => $encryptedToken,
                'encrypted_key'=> $encryptedKey,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch token',
                'error' => $response->body() // Get the raw error response
            ], $response->status());
        }
    }
}
