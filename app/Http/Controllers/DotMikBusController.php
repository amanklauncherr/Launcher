<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DotMitSourceCities;
use App\Models\TravelHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class DotMikBusController extends Controller
{
    public function GetSourceCities(Request $request)
    {
        $state=$request->query('state');
        $city=$request->query('city');
        try 
        {
            if(!isset($state) && !isset($city))
            {
                return response()->json([
                    'success' => 0,
                    'message' => 'Provide Either City or State'
                ],400);
            }

            if(isset($city))
            {
                $result=DotMitSourceCities::where('City_Name',$city)->get();   
                 return response()->json([
                    'success' => true,
                    'data' => $result,
                ],200);
            }
            if(isset($state))
            {
                $result=DotMitSourceCities::where('State_Name',$state)->get();   
                return response()->json([
                   'success' => true,
                   'data' => $result,
               ],200);
            }
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function AvailableTrip(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
            "sourceId" => 'required|string',
            "destinationId" => 'required|string',
            "date" => "required|string",  //
            "AC" => "nullable|string", 
            "Seater" => "nullable|string",
            "Sleeper" => "nullable|string",
            "Arrival" => "nullable|string",
            "Departure" => "nullable|string",
            "BusName" => "nullable|string"
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

        $payload=[
            "sourceId" => $data['sourceId'],
            "destinationId" => $data['destinationId'],
            "date" => $data['date'],
        ];

        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'], //"eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
            'D-SECRET-KEY' =>  $data['headersKey'],
            // "hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/busBooking/v1/availableTrips';
        
        try 
        {
            $response = Http::withHeaders($headers)->post($url,$payload);
            $result=$response->json();
            $statusCode = $response->status();


            if($result['status'] === false)
            {
                return response()->json([
                 'success' => false,
                 'message' => $result['message'],
                 'error' => $result,
                ],$statusCode);
            }
            else
            {
                if($response->successful())
                {
                    $avaliableTrip=$result['payloads']['data']['availableTrips'];
                    // return response()->json($avaliableTrip);
                    // $Bus=$avaliableTrip['travels'];
                    $BusName=array_map(function($travel){
                        return $travel['travels'] ?? null;
                    },$avaliableTrip);

                    $uniqueBusName=array_values(array_unique(array_filter($BusName)));

                   sort($uniqueBusName);


                    if(isset($data['Arrival']) && isset($data['Departure']))
                    {

                        if($data['Arrival'] === '12AM6AM')
                        {  
                            $arrivalDateTimeLow = "0000";
                            $arrivalDateTimeHigh = "0600";
                        }
                        else if($data['Arrival'] === '6AM12PM')
                        {  
                            $arrivalDateTimeLow = "0600";
                            $arrivalDateTimeHigh = "1200";
                        }
                        else if($data['Arrival'] === '12PM6PM')
                        {   
                            $arrivalDateTimeLow = "1200";
                            $arrivalDateTimeHigh = "1800";
                        }
                        else if($data['Arrival'] === '6PM12AM')
                        {
                            $arrivalDateTimeLow = "1800";
                            $arrivalDateTimeHigh = "2400";
                        }
    
                        if($data['Departure'] === '12AM6AM')
                        {
                            $departureDateTimeLow = "0000";
                            $departureDateTimeHigh = "0600";
                        }
                        else if($data['Departure'] === '6AM12PM')
                        {
                            $departureDateTimeLow = "0600";
                            $departureDateTimeHigh = "1200";
                        }
                        else if($data['Departure'] === '12PM6PM')
                        {   
                            $departureDateTimeLow = "1200";
                            $departureDateTimeHigh = "1800";
                        }
                        else if($data['Departure'] === '6PM12AM')
                        {
                            $departureDateTimeLow = "1800";
                            $departureDateTimeHigh = "2400";
                        }
                        else{
                            return response()->json(
                                [
                                    'success'=>0,
                                    'error'=>'Invalid Arrival or Departure time.'
                                ], 400);
                        }

                        $filteredAD = array_filter($avaliableTrip,function($trips) use($arrivalDateTimeLow,$arrivalDateTimeHigh,$departureDateTimeLow,$departureDateTimeHigh){
                            return $trips['arrivalTime'] >= $arrivalDateTimeLow && $arrivalDateTimeHigh >= $trips['arrivalTime'] &&  $trips['departureTime'] >= $departureDateTimeLow &&  $trips['departureTime'] <= $departureDateTimeHigh;
                        });

                        $avaliableTrip=array_values($filteredAD);
                    }
                    else if (isset($data['Arrival'])) 
                    {                       
                        if($data['Arrival'] === '12AM6AM')
                        {  
                            $arrivalDateTimeLow = "0000";
                            $arrivalDateTimeHigh = "0600";
                        }
                        else if($data['Arrival'] === '6AM12PM')
                        {  
                            $arrivalDateTimeLow = "0600";
                            $arrivalDateTimeHigh = "1200";
                        }
                        else if($data['Arrival'] === '12PM6PM')
                        {   
                            $arrivalDateTimeLow = "1200";
                            $arrivalDateTimeHigh = "1800";
                        }
                        else if($data['Arrival'] === '6PM12AM')
                        {
                            $arrivalDateTimeLow = "1800";
                            $arrivalDateTimeHigh = "2400";
                        }
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
                        }

                        $filteredArrival = array_filter($avaliableTrip,function($trips) use($arrivalDateTimeLow,$arrivalDateTimeHigh){
                            return $trips['arrivalTime'] >= $arrivalDateTimeLow && $arrivalDateTimeHigh >= $trips['arrivalTime'];
                        });
                        $avaliableTrip=array_values($filteredArrival); 
                    }
                    else if (isset($data['Departure'])) 
                    {                       
                        if($data['Departure'] === '12AM6AM')
                        {
                            $departureDateTimeLow = "0000";
                            $departureDateTimeHigh = "0600";
                        }
                        else if($data['Departure'] === '6AM12PM')
                        {
                            $departureDateTimeLow = "0600";
                            $departureDateTimeHigh = "1200";
                        }
                        else if($data['Departure'] === '12PM6PM')
                        {   
                            $departureDateTimeLow = "1200";
                            $departureDateTimeHigh = "1800";
                        }
                        else if($data['Departure'] === '6PM12AM')
                        {
                            $departureDateTimeLow = "1800";
                            $departureDateTimeHigh = "2400";
                        }
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
                        }

                        $filteredDeparture = array_filter($avaliableTrip,function($trips) use($departureDateTimeLow,$departureDateTimeHigh){
                            return $trips['departureTime'] >= $departureDateTimeLow &&  $trips['departureTime'] <= $departureDateTimeHigh;
                        });

                        $avaliableTrip=array_values($filteredDeparture);                        
                    }

                    if(isset($data['AC']))
                    {
                        $AC=$data['AC'];
                        $filteredAC = array_filter($avaliableTrip,function($ACtrip) use($AC){
                            return $ACtrip['AC'] === $AC ;
                        });

                        $avaliableTrip = array_values($filteredAC);
                    }
                    if(isset($data['Seater']))
                    {
                        $Seater=$data['Seater'];
                        $filteredSeater = array_filter($avaliableTrip,function($Trip) use($Seater){
                            return $Trip['seater'] === $Seater ;
                        });

                        $avaliableTrip=array_values($filteredSeater);
                    }
                    if(isset($data['Sleeper']))
                    {
                        $Sleeper=$data['Sleeper'];
                        $filteredSleeper = array_filter($avaliableTrip,function($Trip) use($Sleeper){
                            return $Trip['sleeper'] === $Sleeper ;
                        });

                        $avaliableTrip=array_values($filteredSleeper);
                    }
                    // BusName
                    if(isset($data['BusName']))
                    {
                        $travel=$data['BusName'];
                        $filteredBus = array_filter($avaliableTrip,function($Trip) use($travel){
                            return $Trip['travels'] === $travel ;
                        });
                        $avaliableTrip=array_values($filteredBus);   
                    }


                    $data=$avaliableTrip;

                    $count = count($data);

                    if($count === 0)
                    {
                        return response()->json([
                            'success' => false,
                            'message' => "No Trip Available"
                        ], 404);   
                    }

                    $payloads = [
                        'errors' => [],
                        'data' => [
                            'avaliableTrips' => $data
                        ]
                    ];

                    $status_code = $result['status_code'];
                    $request_id = $result['request_id'];

                    return response()->json([
                        'success' => true,
                        'count' => $count,
                        'status_code' => $status_code,
                        'request_id' => $request_id,
                        'uniqueBus' => $uniqueBusName,
                        'payloads' => $payloads,
                        'result' => $result,
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

    public function CurrentTripDetails(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "tripId" => "required|string",
            'headersToken' => 'required|string',
            'headersKey' => 'required|string'
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
        
        $data=$validator->validated();

        $payload = [
           "tripId" => $data['tripId'],
         ];

        // Headers
        $headers = [
            'D-SECRET-TOKEN' =>  $data['headersToken'], //"eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
            //
            'D-SECRET-KEY' => $data['headersKey'],// "hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
            // 
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/busBooking/v1/tripDetails';

        try {
            // Make the POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result=$response->json();
            $statusCode = $response->status();

            if($result['status'] === false)
            {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result
                ],$statusCode);     
            }
            else{
                if($response->successful())
                {
                    return response()->json([
                        'success' => true,
                        'data' => $result,
                    ], 200);
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

    public function BoardingPointDetails(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "boardingPoint" => "required|string",
            "tripId" => "required|string",
            'headersToken' => 'required|string',
            'headersKey' => 'required|string'
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
        
        $data=$validator->validated();

        $payload = [
           "boardingPoint" => $data['boardingPoint'],
           "tripId" => $data['tripId'],
         ];

        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'], // "eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
            // 
            'D-SECRET-KEY' => $data['headersKey'], // "hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
            // 
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        $url = 'https://api.dotmik.in/api/busBooking/v1/boardingPointDetails';

        try {
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result=$response->json();
            $statusCode = $response->status();

            if($result['status'] === false)
            {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result
                ],$statusCode);   
            }
            else{
                if($response->successful())
                {
                    return response()->json([
                        'success' => true,
                        'data' => $result,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to fetch flight data',
                        'error' => $response->json()
                    ], $response->status());
                }
            }
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function PartialBooking(Request $request)
    {
            $validator = Validator::make($request->all(),[
                "boardingPoint" => "required|string",
                "tripId" => "required|string",
                "dropingPoint" => "required|string",
                "source" => "required|string",
                "destination" => "required|string",
                "serviceCharge" => "required|string",
                "inventoryItems.*.seatName" => "required|string",
                "inventoryItems.*.fare" => "required|numeric",
                "inventoryItems.*.serviceTax" => "required|numeric",
                "inventoryItems.*.operatorServiceCharge" => "required|numeric",
                "inventoryItems.*.ladiesSeat" => "required|string",
                "inventoryItems.*.passenger.name" => "required|string",
                "inventoryItems.*.passenger.mobile" => "required|string|min:10|max:10",
                "inventoryItems.*.passenger.title" => "required|string",
                "inventoryItems.*.passenger.email" => "required|string",
                "inventoryItems.*.passenger.age" => "required|string",
                "inventoryItems.*.passenger.gender" => "required|string",
                "inventoryItems.*.passenger.address" => "required|string",
                "inventoryItems.*.passenger.idType" => "nullable|string",
                "inventoryItems.*.passenger.idNumber" => "nullable|string",
                "inventoryItems.*.passenger.primary" => "nullable|string",
                'headersToken' => 'required|string',
                'headersKey' => 'required|string'
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
            
            $data=$validator->validated();
            
            // return response()->json($data['inventoryItems']);

            $payload = 
            [
                "boardingPoint" => $data['boardingPoint'],
                "tripId" => $data['tripId'],
                "dropingPoint" => $data['dropingPoint'],
                "source" => $data['source'],
                "destination" => $data['destination'],
                "serviceCharge" => $data['serviceCharge'],
                "inventoryItems" => $data['inventoryItems']
            ];

            $headers = [
                'D-SECRET-TOKEN' => $data['headersToken'], 
                //"eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
                // 
                'D-SECRET-KEY' => $data['headersKey'],
                //"hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
                // 
                'CROP-CODE' => 'DOTMIK160614',
                'Content-Type' => 'application/json',
            ];

            $url = 'https://api.dotmik.in/api/busBooking/v1/blockTicket';

            try {
                $response = Http::withHeaders($headers)->timeout(60)->post($url, $payload);
                $result=$response->json();
                $statusCode = $response->status();

                if($result['status'] === false)
                {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);   
                }
                else{
                    if($response->successful())
                    {
                        TravelHistory::create([
                            'user_id' => Auth::guard('api')->id(),
                            'BookingType' => 'BUS',
                            'BookingRef' => $result['payloads']['data']['referenceKey'],
                            'Status'=>'TEMPBOOKED'
                        ]);                       
                        return response()->json([
                            'success' => true,
                            'data' => $result,
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to fetch flight data',
                            'error' => $response->json()
                        ], $response->status());
                    }
                }
            } catch  (\Exception $e) {
                // Handle exception (e.g. network issues)
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred',
                    'error' => $e->getMessage()
                ], 500);
            }
    }

   
   public function BookTicket(Request $request)
   {
     $validator=Validator::make($request->all(),[
        "userRef" => "required|string",
        "amount" => "required|string",
        "baseFare" => "required|string",
        "referenceKey" => "required|string",
        "passengerPhone" => "required|string|max:10|min:10",
        "passengerEmail" => "required|string|email",
        'headersToken' => 'required|string',
        'headersKey' => 'required|string'
        // "ip" => "required|string",
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
    
    $data=$validator->validated();

    $payload = [
            "userRef" => $data["userRef"],
            "amount" => $data["amount"],
            "baseFare" => $data["baseFare"],
            "referenceKey" => $data["referenceKey"],
            "passengerPhone" => $data["passengerPhone"],
            "passengerEmail" => $data["passengerEmail"],
            "ip" => "122.176.72.64",
    ];
    
    // Headers
    $headers = [
        'D-SECRET-TOKEN' => $data['headersToken'],
        //"eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
        // 
        'D-SECRET-KEY' =>  $data['headersKey'],
        // "hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
        //
        'CROP-CODE' => 'DOTMIK160614',
        'Content-Type' => 'application/json',
    ];

    // API URL // dotmik
    $url="https://api.dotmik.in/api/busBooking/v1/bookTicket";

    try {
        // Make the POST request using Laravel HTTP Client
        $response = Http::withHeaders($headers)->post($url, $payload);
        $result=$response->json();
        $statusCode = $response->status();

        if($result['status'] === false)
        {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result
            ],$statusCode);   
        }
        else{
            if($response->successful())
            {
                $History=TravelHistory::where('BookingRef',$data['referenceKey'])->first();
                $History->update([
                    'BookingRef' => $result['payloads']['transaction']['description'],
                    'PnrDetails' => [
                        "pnr" => $result['payloads']['transaction']['description']
                    ],
                    'Status' => "BOOKED",
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $result,
                    'message' => "Bus Booked Successfully"
                ], 200);
                
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
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
        ], 500);
    }   
   }

//    public function generateTicketPdf()
//    {

//        $htmlCode = "<!DOCTYPE html>
//            <html lang='en'>
//            <head>
//            <meta charset='UTF-8'>
//            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//            <title>Flight Ticket</title>
//            <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' rel='stylesheet'>
//            <style>
//                body {
//                    font-family: 'Roboto', sans-serif;
//                    background-color: #f0f2f5;
//                    margin: 0;
//                    padding: 20px;
//                    display: flex;
//                    justify-content: center;
//                    align-items: center;
//                    min-height: 100vh;
//                }
//                .container {
//                    max-width: 800px;
//                    background-color: #ffffff;
//                    border-radius: 10px;
//                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
//                    padding: 20px;
//                }
//                h2, h3 {
//                    text-align: center;
//                    color: #333;
//                }
//                table {
//                    width: 100%;
//                    border-collapse: collapse;
//                    margin-bottom: 20px;
//                }
//                table, th, td {
//                    border: 1px solid #e0e0e0;
//                    padding: 15px;
//                    text-align: left;
//                }
//                th {
//                    background-color: #f7f7f7;
//                    color: #555;
//                    font-weight: bold;
//                }
//                td {
//                    color: #333;
//                }
//                .info-section {
//                    margin-bottom: 20px;
//                }
//                .fare-rules h4 {
//                    margin-top: 0;
//                    color: #555;
//                }
//                .fare-rules p {
//                    font-size: 0.9em;
//                    color: #777;
//                }
//                .badge {
//                    display: inline-block;
//                    padding: 5px 10px;
//                    background-color: #4caf50;
//                    color: white;
//                    border-radius: 5px;
//                    font-size: 0.85em;
//                }
//                .ticket-header {
//                    display: flex;
//                    justify-content: space-between;
//                    align-items: center;
//                    margin-bottom: 20px;
//                    padding-bottom: 15px;
//                    border-bottom: 2px solid #e0e0e0;
//                }
//                .ticket-header img {
//                    height: 50px;
//                }
//            </style>
//        </head>
//        <body>
//        <div class='container'>
//            <div class='ticket-header'>
//                <h2>Bus Ticket</h2>
//                <img src='https://via.placeholder.com/100x50?text=Logo' alt='Airline Logo'>
//            </div>
           
//            <div class='info-section'>
//                    <table>
//                        <tr>
//                            <th>Bus</th>
//                            <td>{$Seg['Airline_Code']}</td>
//                        </tr>
//                    </table>
//                    <table>
//                        <tr>
//                            <th>Depart</th>
//                            <td>{$Seg['Origin_City']} ({$Seg['Origin']}) - {$Seg['Departure_DateTime']}, Terminal {$Seg['Origin_Terminal']}</td>
//                            <th>Arrive</th>
//                            <td>{$Seg['Destination_City']} ({$Seg['Destination']}) - {$Seg['Arrival_DateTime']}, Terminal {$Seg['Destination_Terminal']}</td>
//                        </tr>
//                        <tr>
//                            <th>Duration/Stops</th>
//                            <td>{$Seg['Duration']}</td>
//                            <th>Status</th>
//                            <td><span class='badge'>Confirmed</span></td>
//                        </tr>
//                        <tr>
//                            <th>Cabin</th>
//                            <td>{$Cabin}</td>
//                            <th>Check-In</th>
//                            <td>{$CheckIn}</td>
//                        </tr>
//                    </table>
//                </div>";

//            $htmlCode .= "<h3>Passenger Details</h3>
//            <div class='info-section'>
//                <table>
//                    <tr>
//                        <th>Phone</th>
//                        <td>{$Contact}</td>
//                        <th>Email</th>
//                        <td>{$Email}</td>
//                    </tr>";

//        foreach ($paxDetails as $pax) {
//            $gen = $pax['Gender'] === 0 ? "Male" : "Female";
//            $htmlCode .= "<tr>
//                        <th>Ticket No.</th>
//                        <td>{$pax['TicketDetails'][0]['Ticket_Number']}</td>
//                        <th>Name</th>
//                        <td>{$pax['First_Name']} {$pax['Last_Name']}</td>
//                    </tr>
//                    <tr>
//                        <th>Gender</th>
//                        <td>{$gen}</td>
//                    </tr>";
//        }

//        $htmlCode .= "</table>
//            </div>
//            <h3>Payment Details</h3>
//            <div class='info-section'>
//                <table>
//                    <tr>
//                        <th>Base Fare</th>
//                        <td>INR {$BaseFare}</td>
//                    </tr>
//                    <tr>
//                        <th>Taxes and Fees</th>
//                        <td>INR {$Tax}</td>
//                    </tr>
//                    <tr>
//                        <th>Gross Fare</th>
//                        <td>INR {$TotalAmount}</td>
//                    </tr>
//                </table>
//            </div>
//            <h3>Fare Rule - Onward Journey</h3>
//            <div class='fare-rules'>
//                <h4>Cancellation Charges Per Pax</h4>
//                <table>
//                    <tr>
//                        <th>Timeline</th>
//                        <th>Penalty (Airline Fee)</th>
//                    </tr>";

//        foreach ($CancelArray as $cancel) {
//            $htmlCode .= "<tr>
//                            <td>{$cancel['DurationFrom']} - {$cancel['DurationTo']}</td>
//                            <td>" . ($cancel['value'] === 'Non Refundable' ? $cancel['value'] : 'INR ' . $cancel['value']) . "</td>
//                        </tr>";
//        }

//        $htmlCode .= "</table>
//            <h4>Reschedule Charges Per Pax</h4>
//            <table>
//                <tr>
//                    <th>Timeline</th>
//                    <th>Penalty (Airline Fee)</th>
//                </tr>";

//        foreach ($RescheduleChargesArray as $charges) {
//            $htmlCode .= "<tr>
//                            <td>{$charges['DurationFrom']} - {$charges['DurationTo']}</td>
//                            <td>" . ($charges['value'] === 'Non Refundable' ? $charges['value'] : 'INR ' . $charges['value'] . ' + Difference in Fare') . "</td>
//                        </tr>";
//        }

//        $htmlCode .= "</table>
//            <p>
//                The above timeframe mentioned is the time till which cancellation/reschedule is permitted from the Airline side, and can be canceled by you when performing an online cancellation/reschedule. For any offline cancellation (to be done from our support office), we will need at least 6 hrs of buffer time to process the cancellation/reschedule offline.
//            </p>
//            <p>
//                The above fare rules are just a guideline for your convenience and are subject to changes by the Airline from time to time. The agent does not guarantee the accuracy of cancel/rescheduling fees.
//            </p>
//        </div>
//        </div>
//        </body>
//        </html>";


           
//        $directoryPath = storage_path('app/public/tickets');
//        $fileName = 'ticket-' . uniqid() . '.pdf';
//        $filePath = $directoryPath . '/' . $fileName;

//        // Check if the directory exists, if not, create it
//        if (!file_exists($directoryPath)) {
//            mkdir($directoryPath, 0755, true); // Create directory with appropriate permissions
//        }

//        // Load HTML into PDF and save it to the specified path
//        $pdf = Pdf::loadHTML($htmlCode);

//        // return response()->json($pdf);
//        $pdf->save($filePath);

//        // Return the saved file path
//        return 'tickets/' . $fileName; 
// }

   public function CheckTicket(Request $request)
   {
     $validator=Validator::make($request->all(),[
        "referenceId" => "required|string",
        'headersToken' => 'required|string',
        'headersKey' => 'required|string'
        // "ip" => "required|string",
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
    
    $data=$validator->validated();

    $payload = [
            "referenceId" => $data["referenceId"],
    ];
    
    // Headers
    $headers = [
        'D-SECRET-TOKEN' =>  $data['headersToken'],
        //"eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
        //
        'D-SECRET-KEY' => $data['headersKey'],
        //"hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
        // 
        'CROP-CODE' => 'DOTMIK160614',
        'Content-Type' => 'application/json',
    ];

    // API URL
    $url="https://api.dotmik.in/api/busBooking/v1/checkTicket";

    try {
        // Make the POST request using Laravel HTTP Client
        $response = Http::withHeaders($headers)->post($url, $payload);
        $result=$response->json();
        $statusCode = $response->status();

        if($result['status'] === false)
        {
            return response()->json($result,$statusCode);   
        }
        else
        {
            if($response->successful())
            {
              $busName = $result['payloads']['data']['busType'];
              $dateOfJourney = $result['payloads']['data']['dateOfJourney'];
              $pnr=$result['payloads']['data']['tin'];
             
              $destinationCity=$result['payloads']['data']['dropDetails']['destinationCity'];
              $dropLocation=$result['payloads']['data']['dropDetails']['dropLocation'];
              $dropLocationAddress=$result['payloads']['data']['dropDetails']['dropLocationAddress'];
              $dropLocationLandmark=$result['payloads']['data']['dropDetails']['dropLocationLandmark'];
              $dropTime=$result['payloads']['data']['dropDetails']['dropTime'];
              
              $pickUpLocationAddress=$result['payloads']['data']['pickupDetails']['pickUpLocationAddress'];
              $pickupLocation=$result['payloads']['data']['pickupDetails']['pickupLocation'];
              $pickupLocationLandmark=$result['payloads']['data']['pickupDetails']['pickupLocationLandmark'];
              $pickupTime=$result['payloads']['data']['pickupDetails']['pickupTime'];
              $OriginCity=$result['payloads']['data']['pickupDetails']['sourceCity'];

            //   $pdfFilePath = $this->generateTicketPdf($busName,$dateOfJourney,$pnr,$destinationCity,$dropLocationAddress,$dropLocation,$dropLocationLandmark,$dropTime,$pickUpLocationAddress,$pickupLocation,$pickupLocationLandmark,$pickupTime,$OriginCity);
         
              $History=TravelHistory::where('BookingRef',$data['referenceId'])->first();

              return response()->json($History);
              
              $History->update([
                'PnrDetails' => [
                    'pnr' => $History['PnrDetails'],
                    'busType'=>$result['payloads']['data']['busType']
                    // 'dateOfJourney'=>$result['payload']['data']['dateOfJourney'],
                    // "pnr" => $result['payload']['transaction']['description']['pnr']
                ],
                'PAXTicketDetails' => $result['payloads']['data']['inventoryItems'],

                'TravelDetails' => [
                    'dropDetails' => $result['payloads']['data']['dropDetails'],
                    'pickupDetails' => $result['payloads']['data']['pickupDetails'],
                ],
              ]);

                return response()->json([
                    'success' => true,
                    'data' => $result,
                    'message' => "Ticket Data"
                ], 200);
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
            'error' => $e->getMessage(),
            'errorLine' => $e->getLine()
        ], 500);
    }   
   }

   public function getCancelationData(Request $request)
   {
     $validator=Validator::make($request->all(),[
        "referenceId" => "required|string",
        'headersToken' => 'required|string',
        'headersKey' => 'required|string'
        // "ip" => "required|string",
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
    
        $data=$validator->validated();

        $payload = [
                "referenceId" => $data["referenceId"],
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            // "eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
            'D-SECRET-KEY' => $data['headersKey'],
            //"hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = "https://api.dotmik.in/api/busBooking/v1/getCancelationData";

        try {
            // Make the POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result=$response->json();
            $statusCode = $response->status();

            if($result['status'] === false)
            {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result
                ],$statusCode);   
            }
            else{
                if($response->successful())
                {
                    return response()->json([
                        'success' => true,
                        'data' => $result,
                    ], 200);
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

    public function CancelTicket(Request $request)
    {
      $validator=Validator::make($request->all(),[
        "referenceId" => "required|string",
        "seatsToCancel" => "required|array",
        "seatsToCancel.*" => "required|string",
        'headersToken' => 'required|string',
        'headersKey' => 'required|string'
        // "ip" => "required|string",
      ]);


      if ($validator->fails()) {
        $errors = $validator->errors()->all();
        $formattedErrors = [];

        foreach ($errors as $error) {
            $formattedErrors[] = $error;
        }

        return response()->json([
            'success' => 0,
            'error' => $formattedErrors[0]
        ], 422);
      }
    
        $data=$validator->validated();

        $payload = [
                "referenceId" => $data["referenceId"],
                "seatsToCancel" => $data["seatsToCancel"]
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            // "eg+szn0TFMvO4FMoMNU5MsxGr7MjLgSvdidA5imOJZ21cyD6/mJnWZz8Tc+VZVLf",
            'D-SECRET-KEY' =>  $data['headersKey'],
            //"hCPNl+FDiFGctdqlEqYy3RO+O2TgSHpV1svQJxolFybCLrKHtd7aeuGIRyVyDXc/",
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = "https://api.dotmik.in/api/busBooking/v1/cancelTicket";

        try {
            // Make the POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result=$response->json();
            $statusCode = $response->status();

            if($result['status'] === false)
            {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result
                ],$statusCode);   
            }
            else{
                if($response->successful())
                {
                    return response()->json([
                        'success' => true,
                        'data' => $result,
                        'message' => $result['message']
                    ], 200);
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



//     "AC": "true", //
//     "arrivalTime": "1740", //
//     "departureTime": "1202", //

//     "availableSeats": "10",
//     "availableSingleSeat": "0",
//     "duration": "8:58 hrs",

//     "sleeper": "false", //
//     "seater": "true",  //

// {
//     "AC": "false",
//     "additionalCommission": "0",
//     "agentServiceCharge": "0.00",
//     "agentServiceChargeAllowed": "true",
//     "arrivalTime": "1740",
//     "availCatCard": "false",
//     "availSrCitizen": "false",
//     "availableSeats": "10",
//     "availableSingleSeat": "0",
//     "avlWindowSeats": "-1",
//     "boCommission": "5.00",
//     "boPriorityOperator": "false",
//     "boardingTimes": {
//         "address": "asdasdasdads",
//         "bpId": "252884",
//         "bpName": "Old Airport Road",
//         "contactNumber": "9818649039",
//         "landmark": "Murgeshpallya",
//         "location": "Old Airport Road",
//         "prime": "true",
//         "time": "1202"
//     },
//     "bookable": "true",
//     "bpDpSeatLayout": "false",
//     "busCancelled": "false",
//     "busImageCount": "-1",
//     "busRoutes": "Bangalore-Chikmagalur-Hyderabad",
//     "busType": "Bharat benz Non A/C Seater Pushback (1+1)",
//     "busTypeId": "110",
//     "callFareBreakUpAPI": "false",
//     "cancellationCalculationTimestamp": "Tue Oct 29 20:02:00 IST 2024",
//     "cancellationPolicy": "0:12:100:0;12:24:50:0;24:-1:10:0",
//     "departureTime": "1202",
//     "destination": "6",
//     "doj": "2024-10-29T00:00:00+05:30",
//     "dropPointMandatory": "false",
//     "droppingTimes": {
//         "address": "Testingg",
//         "bpId": "235765",
//         "bpName": "APSRTC M G Bus Station",
//         "contactNumber": "1234567890",
//         "landmark": "Testingg",
//         "location": "APSRTC M G Bus Station",
//         "prime": "true",
//         "time": "1740"
//     },
//     "duration": "8:58 hrs",
//     "exactSearch": "false",
//     "fareDetails": {
//         "bankTrexAmt": "0",
//         "baseFare": "10.00",
//         "bookingFee": "0",
//         "childFare": "0",
//         "gst": "0.50",
//         "levyFare": "0",
//         "markupFareAbsolute": "0",
//         "markupFarePercentage": "0",
//         "opFare": "0",
//         "opGroupFare": "0",
//         "operatorServiceChargeAbsolute": "0.00",
//         "operatorServiceChargePercentage": "0.00",
//         "serviceCharge": "0.00",
//         "serviceTaxAbsolute": "0.50",
//         "serviceTaxPercentage": "5",
//         "srtFee": "0",
//         "tollFee": "0",
//         "totalFare": "10.50"
//     },
//     "fares": "10.50",
//     "flatComApplicable": "false",
//     "flatSSComApplicable": "false",
//     "gdsCommission": "0",
//     "groupOfferPriceEnabled": "false",
//     "happyHours": "false",
//     "id": "2000000150500114514",
//     "idProofRequired": "false",
//     "imagesMetadataUrl": "/images/null",
//     "isLMBAllowed": "false",
//     "liveTrackingAvailable": "false",
//     "maxSeatsPerTicket": "6",
//     "nextDay": "false",
//     "noSeatLayoutEnabled": "false",
//     "nonAC": "true",
//     "offerPriceEnabled": "false",
//     "operator": "25541201",
//     "otgEnabled": "false",
//     "partialCancellationAllowed": "true",
//     "partnerBaseCommission": "5.00",
//     "primaryPaxCancellable": "true",
//     "primo": "false",
//     "rbServiceId": "114514",
//     "routeId": "2000000100000114514",
//     "rtc": "false",
//     "SSAgentAccount": "false",
//     "seater": "true",
//     "selfInventory": "false",
//     "serviceStartTime": "2024-10-29 20:02:00",
//     "singleLadies": "false",
//     "sleeper": "false",
//     "source": "3",
//     "tatkalTime": "0",
//     "travels": "Poppin Travles",
//     "unAvailable": "false",
//     "vaccinatedBus": "false",
//     "vaccinatedStaff": "false",
//     "vehicleType": "BUS",
//     "zeroCancellationTime": "0",
//     "mTicketEnabled": "true"
// },