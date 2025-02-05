<?php

namespace App\Http\Controllers;
use App\Models\DotMitSourceCities;
use Illuminate\Support\Facades\DB;
use App\Models\Card;
use App\Models\About;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class DataInsert extends Controller
{


    public function storeExchange(Request $request){
        
        $response = Http::get('https://api.exchangerate-api.com/v4/latest/INR');

        if ($response->successful()) {
            $object = $response->json(); // Already returns an array
            $data =  $object;

            DB::table('exchange_rates')->insert([
                'rates' => json_encode($data['rates']),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['message' => 'Data inserted successfully!']);
        }
        
    }

    public function getExchange(Request $request){
    
        $data = DB::table('exchange_rates')->latest()->first();
        return ([
            'rates' => json_decode($data->rates),
            'date' => $data->created_at
        ]); 

    }

    public function getAirportName(Request $request){
        $data = $request->iata_code;
        $iata = DB::table('iatacodes')->where('iata_code',$data)->first();
        return $iata;
    }


    public function dbDetails(Request $request)
    {
        

        $data = DB::table('travel_histories')->get();

        $user = DB::table('users')->get();

        return response()->json([
            'travel_histories' => $data,
            'users' => $user,
        ]);


    }

    public function addBusStation(Request $request){

        $data = new DotMitSourceCities();
        $data->City_ID = $request->City_ID;
        $data->City_Name = $request->City_Name;
        $data->State_ID = $request->State_ID;
        $data->State_Name = $request->State_Name;
        $data->LocationType =  $request->LocationType;
        $data->Latitude = $request->Latitude;
        $data->Longitude = $request->Longitude;
        if($data->save()){
            return response()->json(['message' => 'Data inserted successfully!']);
        }else{
            return response()->json(['message' => 'Data not inserted successfully!']);
        }

    }

    public function getCity(Request $request){
    
        $data = DotMitSourceCities::where('City_Name', 'LIKE', '%'.$request->City_Name.'%')->get();
        return response()->json($data);

    }



    // public function getSourceCity(Request $request){

            
    //     $curl = curl_init();
                
    //     curl_setopt_array($curl, array(
    //       CURLOPT_URL => 'https://api.dotmik.in/api/busBooking/v1/sourceCities',
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_ENCODING => '',
    //       CURLOPT_MAXREDIRS => 10,
    //       CURLOPT_TIMEOUT => 0,
    //       CURLOPT_FOLLOWLOCATION => true,
    //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //       CURLOPT_CUSTOMREQUEST => 'GET',
    //       CURLOPT_HTTPHEADER => array(
    //         'D-SECRET-TOKEN: eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf',
    //         'D-SECRET-KEY: hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/',
    //         'CROP-CODE: DOTMIK160614'
    //       ),
    //     ));
        
    //     $response = curl_exec($curl);
        
    //     curl_close($curl);
    //     echo $response;
        


    // }
   
// public function addDestinationData(Request $request){

//     // Data to insert
//     $data = [
//         'name' => 'Rishikesh',
//         'city' => 'Rishikesh',
//         'state' => 'Uttarakhand',
//         'destination_type'=>'Mountain',
//         'thumbnail_image'=>'https://res.cloudinary.com/douuxmaix/image/upload/v1721655735/gkayacn65zg87urcnauc.jpg',
//         'images'=>'["https:\/\/res.cloudinary.com\/douuxmaix\/image\/upload\/v1721655736\/hngg1ckd61shd2uxcqu8.jpg","https:\/\/res.cloudinary.com\/douuxmaix\/image\/upload\/v1721647269\/s9afhaw0e4crysgfgmvd.jpg"]',
//         'short_description'=>'a short trip to Rishikesh',
//         'description'=>'A detailed description of the destination',
//     ];

//     // Insert data using DB facade (Query Builder)
//     DB::table('destinations')->insert($data);

//     return response()->json(['message' => 'Data inserted successfully!']);

// }


   
   

   
    
}
