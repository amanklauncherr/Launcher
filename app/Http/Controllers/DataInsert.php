<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Card;
use App\Models\About;
use App\Models\DotMitSourcesCities;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DataInsert extends Controller
{

    public function dbDetails(Request $request)
    {
        $dbName = config('database.connections.mysql.database');
        $dbUsername = config('database.connections.mysql.username');
        $dbPassword = config('database.connections.mysql.password');

        // return response()->json([
        //     'db_name'     => $dbName,
        //     'db_username' => $dbUsername,
        //     'db_password' => $dbPassword,
        // ]);

        $data = DB::table('travel_histories')->get();

        $user = DB::table('users')->get();

        return response()->json([
            'db_name'     => $dbName,
            'db_username' => $dbUsername,
            'db_password' => $dbPassword,
            'travel_histories' => $data,
            'users' => $user,
        ]);


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
