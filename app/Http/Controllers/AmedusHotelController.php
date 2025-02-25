<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class AmedusHotelController extends Controller
{
   
    public function Create_access_token(Request $request)
    {
       
        $payload = [
            "grant_type" => 'client_credentials',
            'client_id' => 'fbHM2EoHTyvzDBNsGyqFv6sa5uGpt9En',
            'client_secret' => 'MgnbcTliA1P2cZzH'
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://test.api.amadeus.com/v1/security/oauth2/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=fbHM2EoHTyvzDBNsGyqFv6sa5uGpt9En&client_secret=MgnbcTliA1P2cZzH',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);

        return $result;

    }
   

}
