<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DotMikBusController extends Controller
{
    //

    public function GetSourceCities(Request $request)
    {
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
                return response()->json($result,$statusCode);
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

    public function AvaliableTrip(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
            "sourceId" => 'required|string',
            "destinationId" => 'required|string',
            "date" => "required|string",
            "AC" => "nullable|string",
            "Seater" => "nullable|string",
            "Sleeper" => "nullable|string",
            "Arrival" => "nullable|string",
            "Departure" => "nullable|string"
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
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
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
                return response()->json($result,$statusCode);
            }
            else{
                if($response->successful())
                {
                    $avaliableTrip=$result['payloads']['data']['availableTrips'];

                    // return response()->json($avaliableTrip);

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
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
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
                            return response()->json('Invalid Arrival time or condition.', 400);
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

                        $avaliableTrip=array_values($filteredAC);
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

                    $data=$avaliableTrip;

                    $count = count($data);

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
                        'request_id' =>$request_id,
                        'payloads' => $payloads,
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
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
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
                return response()->json($result,$statusCode);   
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
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
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
                return response()->json($result,$statusCode);   
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
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
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
                return response()->json($result,$statusCode);   
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