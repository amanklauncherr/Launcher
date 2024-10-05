<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DotMikBusController extends Controller
{
    //

    public function GetSourceCities(Request $request){
        $validator= Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
            'city_name' => 'required|string'
        ]);
        
        if($validator->fails())
        {
            $errors=$validator->errors()->all();
            $formattedErrors = [];

            foreach($errors as $error)
            {
                $formattedErrors[] = $error;
            }

            return response()->json([
                'success' => 0,
                'error' => $formattedErrors[0]
            ],422);
        }

        $data= $validator->validated();

        if($data['city_name'])
        {
            $headers = [
                'D-SECRET-TOKEN' => $data['headersToken'],
                'D-SECRET-KEY' => $data['headersKey'],
                'CROP-CODE' => 'DOTMIK160614',
                'Content-Type' => 'application/json',
            ];
    
            // API URL
            $url = 'https://api.dotmik.in/api/busBooking/v1/sourceCities';
            
        try 
        {
            $response = Http::withHeaders($headers)->get($url);
            $result=$response->json();
            $statusCode = $response->status();

            if($result['status'] === false)
            {
                return response()->json([$result],$statusCode);
            }
            else{
                if($response->successful())
                {
                    $status_code = $result['status_code'];
                    $request_id = $result['request_id'];
        
                    $cities= $result['payloads']['data']['cities'];      

                    $name=$data['city_name'];

                    $data = array_filter($cities,function($city) use($name){
                        return $city['name'] === $name;
                    });

                    return response()->json([
                        'success' => true,
                        'status_code' => $status_code,
                        'request_id' =>$request_id,
                        'data' => $data,
                    ],$response->status());
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to fetch flight data',
                        'error' => $response->json()
                    ], $response->status());
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
        }

    }
}
