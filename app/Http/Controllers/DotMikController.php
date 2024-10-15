<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;

class DotMikController extends Controller
{
    //
    public function SearchFlight(Request $request)
    {

        $validator=Validator::make($request->all(),[
            "origin" => "required|string",
            "destination" => "required|string",
            "travelDate" => "required|date",
            "travelType" => "required|string",
            "bookingType" => "required|string",
            "tripId" => "required|string",
            "adultCount" => "required|string",
            "childCount" => "required|string",
            "infantCount" => "required|string",
            "classOfTravel" => "required|string",
            "airlineCode" => "nullable|string",

            // for Header  
            "headersToken" => "required|string",
            "headersKey" => "required|string",

            // for Filter
            "Refundable" => "nullable|boolean",
            'Arrival' => 'nullable|string',
            'Departure' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
    
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
    
            return response()->json([
                'success' => false,
                'message' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879888"
            ],
            "travelType" => $data['travelType'], // Domestic or International
            "bookingType" => $data['bookingType'], // One way
            "tripInfo" => [
                "origin" => $data['origin'],
                "destination" => $data['destination'],
                "travelDate" => $data['travelDate'], // MM/DD/YYYY
                "tripId" => $data['tripId'] // Ongoing trip
            ],
            "adultCount" => $data['adultCount'],
            "childCount" => $data['childCount'],
            "infantCount" => $data['infantCount'],
            "classOfTravel" => $data['classOfTravel'], // Economy
            "filteredAirLine" => [
                 "airlineCode" => $data['airlineCode'] ?? ''
            ]
        ];

        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/searchFlight';

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
            else
            {   
                if ($response->successful()) 
                {

                    $dataa = $result['payloads']['data']['tripDetails'];
                    
                    // return response()->json($dataa);

                    $flights = $dataa[0]['Flights']; // Flights is already an array
                    
                    // Filter flights based on Departure and Arrival times
                    if(isset($data['Arrival']) && isset($data['Departure']))
                    {

                        if($data['Arrival'] === '12AM6AM')
                        {  
                            $arrivalDateTimeLow = "{$data['travelDate']} 00:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 06:00";
                        }
                        else if($data['Arrival'] === '6AM12PM')
                        {  
                            $arrivalDateTimeLow = "{$data['travelDate']} 06:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 12:00";
                        }
                        else if($data['Arrival'] === '12PM6PM')
                        {   
                            $arrivalDateTimeLow = "{$data['travelDate']} 12:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 18:00";
                        }
                        else if($data['Arrival'] === '6PM12AM')
                        {
                            $arrivalDateTimeLow = "{$data['travelDate']} 18:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 24:00";
                        }
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
                        }

                        if($data['Departure'] === '12AM6AM')
                        {
                            $departureDateTimeLow = "{$data['travelDate']} 00:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 06:00";
                        }
                        else if($data['Departure'] === '6AM12PM')
                        {
                            
                            $departureDateTimeLow = "{$data['travelDate']} 06:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 12:00";
                        }
                        else if($data['Departure'] === '12PM6PM')
                        {   
                            $departureDateTimeLow = "{$data['travelDate']} 12:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 18:00";
                        }
                        else if($data['Departure'] === '6PM12AM')
                        {
                            $departureDateTimeLow = "{$data['travelDate']} 18:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 24:00";
                        }
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
                        }
                        
                        $filteredSegments = collect($flights)->filter(function ($flight) use ( $arrivalDateTimeLow,$arrivalDateTimeHigh,$departureDateTimeLow,$departureDateTimeHigh) {
                            return $flight['Segments'][0]['Arrival_DateTime'] >= $arrivalDateTimeLow && $arrivalDateTimeHigh >= $flight['Segments'][0]['Arrival_DateTime'] &&  $flight['Segments'][0]['Departure_DateTime'] >= $departureDateTimeLow &&  $flight['Segments'][0]['Departure_DateTime'] <= $departureDateTimeHigh;
                        });
    
                        $filteredFlights = $filteredSegments->all();
    
                        $filteredFlights = array_values($filteredFlights); 
                    }
                    else if (isset($data['Arrival'])) 
                    {                       
                        if($data['Arrival'] === '12AM6AM')
                        {
                            $arrivalDateTimeLow = "{$data['travelDate']} 00:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 06:00";
                        }
                        else if($data['Arrival'] === '6AM12PM')
                        {
                            
                            $arrivalDateTimeLow = "{$data['travelDate']} 06:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 12:00";
                        }
                        else if($data['Arrival'] === '12PM6PM')
                        {   
                            $arrivalDateTimeLow = "{$data['travelDate']} 12:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 18:00";
                        }
                        else if($data['Arrival'] === '6PM12AM')
                        {
                            $arrivalDateTimeLow = "{$data['travelDate']} 18:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $arrivalDateTimeHigh = "{$data['travelDate']} 24:00";
                        }
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
                        }

                        $filteredSegments = collect($flights)->filter(function ($flight) use ( $arrivalDateTimeLow,$arrivalDateTimeHigh) {
                        return $flight['Segments'][0]['Arrival_DateTime'] >= $arrivalDateTimeLow && $arrivalDateTimeHigh >= $flight['Segments'][0]['Arrival_DateTime'];
                        });

                        $filteredFlights = $filteredSegments->all();

                        $filteredFlights=array_values($filteredFlights);                    
                    }
                    else if (isset($data['Departure'])) 
                    {                       
                        if($data['Departure'] === '12AM6AM')
                        {
                            $departureDateTimeLow = "{$data['travelDate']} 00:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 06:00";
                        }
                        else if($data['Departure'] === '6AM12PM')
                        {
                            
                            $departureDateTimeLow = "{$data['travelDate']} 06:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 12:00";
                        }
                        else if($data['Departure'] === '12PM6PM')
                        {   
                            $departureDateTimeLow = "{$data['travelDate']} 12:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 18:00";
                        }
                        else if($data['Departure'] === '6PM12AM')
                        {
                            $departureDateTimeLow = "{$data['travelDate']} 18:00";
                            // return response()->json($arrivalDateTimeLow, 400);
                            $departureDateTimeHigh = "{$data['travelDate']} 24:00";
                        }
                        else{
                            return response()->json('Invalid Arrival time or condition.', 400);
                        }

                        $filteredSegments = collect($flights)->filter(function ($flight) use ( $departureDateTimeLow,$departureDateTimeHigh) {
                        return $flight['Segments'][0]['Departure_DateTime'] >= $departureDateTimeLow && $departureDateTimeHigh >= $flight['Segments'][0]['Departure_DateTime'];
                        });

                        $filteredFlights = $filteredSegments->all();
                        $filteredFlights=array_values($filteredFlights);

                    } 
                    else {
                        $filteredFlights = $flights; // No filter, return all flights
                        // return response()->json($filteredFlights[0]['Fares'][0]['Refundable'],400);
                    }

                    if(isset($data['Refundable']))
                    {
                        // return response()->json($filteredFlights['Fare']);
                        $refundable = $data['Refundable'];
                        $filtered = array_filter($filteredFlights, function($flight) use($refundable) {
                            return $flight['Fares'][0]['Refundable'] === $refundable ;
                        });
                        $filtered=array_values($filtered);
                    }
                    else{
                        // return response()->json('Helloji');
                        $filtered = $filteredFlights;
                    }

                    // Extract distinct airline codes
                    $airlineCodes = array_map(function($flight) {
                        return $flight['Airline_Code'] ?? null; // Handle cases where 'Airline_Code' may not exist
                    }, $filtered);

                    // Remove null values and get distinct airline codes
                    $distinctAirlineCodes = array_unique(array_filter($airlineCodes));

                    // Re-index array to remove numeric keys
                    $distinctAirlineCodes = array_values($distinctAirlineCodes);

                    $count = count($filtered);

                    $payloads = [
                            'errors' => [],
                            'data' => [
                                'tripDetails' => [
                                    [
                                        'Flights' => $filtered
                                    ]
                                ]
                            ]
                    ];
                    
                    return response()->json([
                        'status' => true,
                        'count' => $count,
                        'status_code' => $result['status_code'],
                        'request_id' => $result['request_id'],
                        'SearchKey' => $result['payloads']['data']['searchKey'],
                        'AirlineCodes' =>  $distinctAirlineCodes,
                        'payloads' => $payloads,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
        } catch (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }    
    }

    public function fareRule(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'SearchKey' => 'required|string',
            'FareID' => 'required|string',
            'FlightKey' => 'required|string',
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
                'success' => false,
                'message' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879888"
            ],
            "searchKey" => $data['SearchKey'],
            "fareId" => $data['FareID'],
            "flightKey" => $data['FlightKey']            
        ];

        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/fareRule';

        try {
            // Make the POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result = $response->json();            
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
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function RePrice(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'SearchKey' => 'required|string',
            'FareID' => 'required|string',
            'FlightKey' => 'required|string',
            'CustomerContact' => "required|string|min:10|max:10",
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
                'success' => false,
                'message' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879888"
            ],
            "searchKey" => $data['SearchKey'],
            "fareId" => $data['FareID'],
            "flightKey" => $data['FlightKey'],
            "customerMobile" => $data['CustomerContact'],
            "GSTIN" => ""
        ];

        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/rePrice';

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
                    ], $statusCode);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function TemporaryBooking(Request $request){
        $validator = Validator::make($request->all(), [
            'passenger_details.mobile' => 'required|string',
            'passenger_details.whatsApp' => 'required|string',
            'passenger_details.email' => 'required|string',
            'passenger_details.paxId' => 'required|integer',
            'passenger_details.paxType' => 'required|integer', // 0-ADT/1-CHD/2-INF
            'passenger_details.title' => 'required|string', // MR, MRS, MS; MSTR, MISS for child/infant
            'passenger_details.firstName' => 'required|string',
            'passenger_details.lastName' => 'required|string',
            'passenger_details.age' => 'nullable|integer',
            'passenger_details.gender' => 'required|integer',  // 0-Male, 1-Female
            'passenger_details.dob' => 'required|date',
            'passenger_details.passportNumber' => 'nullable|string',
            'passenger_details.passportIssuingAuthority' => 'nullable|string',
            'passenger_details.passportExpire' => 'nullable|date',
            'passenger_details.nationality' => 'nullable|string',
            'passenger_details.pancardNumber' => 'nullable|string',
            'passenger_details.frequentFlyerDetails' => 'nullable|string',
            'gst.isGst' => 'required|string',
            'gst.gstNumber' => 'nullable|string',
            'gst.gstName' => 'nullable|string',
            'gst.gstAddress' => 'nullable|string',
            'searchKey' => 'required|string',
            'FlightKey' => 'required|string',
            'headersToken' => 'required|string',
            'headersKey' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'message' => $errors[0] // Return the first error
            ], 422);
        }
        
        $data = $validator->validated();


        // return response()->json($data['passenger_details']['mobile']);

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879887"
            ],
            "passengers" => [
                "mobile" => $data['passenger_details']['mobile'],
                "whatsApp" => $data['passenger_details']['whatsApp'],
                "email" => $data['passenger_details']['email'],
                "paxDetails" => [
                    [
                        "paxId" => $data['passenger_details']['paxId'],
                        "paxType" => $data['passenger_details']['paxType'],
                        "title" => $data['passenger_details']['title'],
                        "firstName" => $data['passenger_details']['firstName'],
                        "lastName" => $data['passenger_details']['lastName'],
                        "gender" => $data['passenger_details']['gender'],
                        "age" => $data['passenger_details']['age'] ?? null,
                        "dob" => $data['passenger_details']['dob'],
                        "passportNumber" => $data['passenger_details']['passportNumber'],
                        "passportIssuingAuthority" => $data['passenger_details']['passportIssuingAuthority'],
                        "passportExpire" => $data['passenger_details']['passportExpire'],
                        "nationality" => $data['passenger_details']['nationality'],
                        "pancardNumber" => $data['passenger_details']['pancardNumber'] ?? null,
                        "frequentFlyerDetails" => $data['passenger_details']['frequentFlyerDetails'] ?? null
                    ]
                ]
            ],
            "gst" => [
                "isGst" => $data['gst']['isGst'],
                "gstNumber" => $data['gst']['gstNumber'],
                "gstName" => $data['gst']['gstName'],
                "gstAddress" => $data['gst']['gstAddress']
            ],
            "flightDetails" => [
                [
                    "searchKey" => $data['searchKey'],
                    "flightKey" => $data['FlightKey'],
                    "ssrDetails" => [] // Empty SSR details
                ]
            ],
            "costCenterId" => 0,
            "projectId" => 0,
            "bookingRemark" => "Test booking with PAX details",
            "corporateStatus" => 0,
            "corporatePaymentMode" => 0,
            "missedSavingReason" => null,
            "corpTripType" => null,
            "corpTripSubType" => null,
            "tripRequestId" => null,
            "bookingAlertIds" => null
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];
        
        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/tempBooking';
        
        try {
            // Make POST request
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result = $response->json();
            $statusCode = $response->status();
            

            if ($result['status'] === false) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result
                ],$statusCode);
            } else {
                if ($response->successful()) {
                    return response()->json([
                        'success' => true,
                        'data' => $result,
                    ], $statusCode);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }        
    }

    public function Ticketing(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'BookingRef' => 'required|string',
            "TicketingType" => "required|string",
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
                'success' => false,
                'message' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879887"
            ],
            "bookingRef" => $data['BookingRef'],
            "ticketingType" => $data['TicketingType']
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/ticketing';
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
                    ], $statusCode);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }   
    }

    // public function History(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'headersToken' => 'required|string',
    //         'headersKey' => 'required|string',
    //         "fromDate" => "required|string", //date in (MM/dd/YYYY)
    //         "toDate" => "required|string",  //date in (MM/dd/YYYY)
    //         "month" => "required|string", // Month of booking for July (eg: 07)
    //         "year" => "required|string", //year of booking(eg:2024)
    //         "type" => "required|string" //Possible values are 0 - BOOKING_DATE/ 1 - BOOKING_DATE_LIVE/ 2 - BOOKING_DATE_CANCELLED/ 3-BLOCKED
    //     ]);     

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->all(); // Get all error messages
    //         $formattedErrors = [];
    
    //         foreach ($errors as $error) {
    //             $formattedErrors[] = $error;
    //         }
    
    //         return response()->json([
    //             'success' => false,
    //             'message' => $formattedErrors[0]
    //         ], 422);
    //     }
        
    //     $data=$validator->validated();

    //     $payload = [
    //         "deviceInfo" => [
    //             "ip" => "122.161.52.233",
    //             "imeiNumber" => "12384659878976879887"
    //         ],
    //         "fromDate" => $data['fromDate'], //date in (MM/dd/YYYY)
    //         "todate" => $data['toDate'],  //date in (MM/dd/YYYY)
    //         "month" => $data['month'], // Month of booking for July (eg: 07)
    //         "year" => $data['year'], //year of booking(eg:2024)
    //         "type" => $data['type'] //
    //     ];
        
    //     // Headers
    //     $headers = [
    //         'D-SECRET-TOKEN' => $data['headersToken'],
    //         'D-SECRET-KEY' => $data['headersKey'],
    //         'CROP-CODE' => 'DOTMIK160614',
    //         'Content-Type' => 'application/json',
    //     ];

    //     // API URL
    //     $url = 'https://api.dotmik.in/api/flightBooking/v1/history';

    //     try {
    //         // Make the POST request using Laravel HTTP Client
    //         $response = Http::withHeaders($headers)->post($url, $payload);
    //         $result=$response->json();
    //         $statusCode = $response->status();

    //         if($result['status'] === false)
    //         {
    //             return response()->json($result,$statusCode);   
    //         }
    //         else{
    //             if($response->successful())
    //             {
    //                 return response()->json([
    //                     'success' => true,
    //                     'data' => $result,
    //                 ], 200);
    //             } else {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Failed to fetch flight data',
    //                     'error' => $response->json()
    //                 ], $response->status());
    //             }
    //         }
    //         //code...
    //     } catch  (\Exception $e) {
    //         // Handle exception (e.g. network issues)
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }   
    // }

    public function generateTicketPdf($Origin,$Origin_terminal,$Origin_Code,$Destination,$Destination_Code,$Destination_terminal,$first,$last,$PNR,$Ticket,$ArrivalTime,$DepartureTime,$ArrivalDate,$DepartureDate,$flight_type,$Duration,$Aircraft,$Cabin,$CheckIn, $gen, $Email,$Contact,$BaseFare, $TotalAmount,$CancelArray, $RescheduleChargesArray, $FlightNO,$AirlineCode, $Tax)
    {

        $htmlCode = "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Flight Ticket</title>
            <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' rel='stylesheet'>
            <style>
                body {
                    font-family: 'Roboto', sans-serif;
                    background-color: #f0f2f5;
                    margin: 0;
                    padding: 20px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .container {
                    max-width: 800px;
                    background-color: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }
                h2, h3 {
                    text-align: center;
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                table, th, td {
                    border: 1px solid #e0e0e0;
                    padding: 15px;
                    text-align: left;
                }
                th {
                    background-color: #f7f7f7;
                    color: #555;
                    font-weight: bold;
                }
                td {
                    color: #333;
                }
                .info-section {
                    margin-bottom: 20px;
                }
                .fare-rules h4 {
                    margin-top: 0;
                    color: #555;
                }
                .fare-rules p {
                    font-size: 0.9em;
                    color: #777;
                }
                .badge {
                    display: inline-block;
                    padding: 5px 10px;
                    background-color: #4caf50;
                    color: white;
                    border-radius: 5px;
                    font-size: 0.85em;
                }
                .ticket-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    padding-bottom: 15px;
                    border-bottom: 2px solid #e0e0e0;
                }
                .ticket-header img {
                    height: 50px;
                }
            </style>
        </head>
        <body>
        <div class='container'>
            <div class='ticket-header'>
                <h2>Flight Ticket</h2>
                <img src='https://via.placeholder.com/100x50?text=Logo' alt='Airline Logo'>
            </div>
            <div class='info-section'>
                <table>
                    <tr>
                        <th>Flight</th>
                        <td>{$AirlineCode}-{$FlightNO}</td>  
                        <th>Class</th>
                        <td>{$flight_type}</td>
                    </tr>
                    <tr>
                        <th>Aircraft Type</th>
                        <td>Airbus A{$Aircraft}</td>
                    </tr>
                </table>
        
                <table>
                    <tr>
                        <th>Depart</th>
                        <td>{$Origin} ({$Origin_Code}) - {$DepartureTime}, {$DepartureDate}, Terminal {$Origin_terminal}</td>
                        <th>Arrive</th>
                        <td>{$Destination} ({$Destination_Code}) - {$ArrivalTime}, {$ArrivalDate}, Terminal {$Destination_terminal}</td>
                    </tr>
                    <tr>
                        <th>Duration/Stops</th>
                        <td>{$Duration}</td>
                        <th>Status</th>
                        <td><span class='badge'>Confirmed</span></td>
                    </tr>
                </table>
            </div>
        
            <h3>Passenger Details</h3>
            <div class='info-section'>
                <table>
                    <tr>
                        <th>Ticket No.</th>
                        <td>{$Ticket}</td>
                        <th>Name</th>
                        <td>{$first} {$last}</td>
                    </tr>
                    <tr>
                        <th>Cabin</th>
                        <td>{$Cabin}</td>
                        <th>Check-In</th>
                        <td>{$CheckIn}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{$gen}</td>
                        <th>Status</th>
                        <td>Confirmed</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{$Contact}</td>
                        <th>Email</th>
                        <td>{$Email}</td>
                    </tr>
                </table>
            </div>
        
            <h3>Payment Details</h3>
            <div class='info-section'>
                <table>
                    <tr>
                        <th>Base Fare</th>
                        <td>₹ {$BaseFare}</td>
                    </tr>
                    <tr>
                        <th>Taxes and Fees</th>
                        <td>₹ {$Tax}</td>
                    </tr>
                    <tr>
                        <th>Gross Fare</th>
                        <td>₹ {$TotalAmount}</td>
                    </tr>
                </table>
            </div>
        
            <h3>Fare Rule - Onward Journey</h3>
            <div class='fare-rules'>
                <h4>Cancellation Charges Per Pax</h4>
                <table>
                    <tr>
                        <th>Timeline</th>
                        <th>Penalty (Airline Fee)</th>
                    </tr>";
        
        foreach ($CancelArray as $cancel) {
            $htmlCode .= "<tr>
                              <td>{$cancel['DurationFrom']} Hours - {$cancel['DurationTo']} Hours</td>
                              <td>" . ($cancel['value'] === 'Non Refundable' ? $cancel['value'] : '₹ ' . $cancel['value']) . "</td>
                          </tr>";
        }
        
        $htmlCode .= "</table>
                <h4>Reschedule Charges Per Pax</h4>
                <table>
                    <tr>
                        <th>Timeline</th>
                        <th>Penalty (Airline Fee)</th>
                    </tr>";
        
        foreach ($RescheduleChargesArray as $charges) {
            $htmlCode .= "<tr>
                              <td>{$charges['DurationFrom']} Hours - {$charges['DurationTo']} Hours</td>
                              <td>" . ($charges['value'] === 'Non Refundable' ? $charges['value'] : '₹ ' . $charges['value'] . ' + Difference in Fare') . "</td>
                          </tr>";
        }
        
        $htmlCode .= "</table>
        
                <p>
                    The above timeframe mentioned is the time till which cancellation/reschedule is permitted from the Airline side, and can be canceled by you when performing an online cancellation/reschedule. For any offline cancellation (to be done from our support office), we will need at least 6 hrs of buffer time to process the cancellation/reschedule offline.
                </p>
                <p>
                    The above fare rules are just a guideline for your convenience and are subject to changes by the Airline from time to time. The agent does not guarantee the accuracy of cancel/rescheduling fees.
                </p>
            </div>
        </div>
        </body>
        </html>";
        
        // // Load HTML into PDF
    // $pdf = Pdf::loadHTML($htmlCode);

    // // Save the PDF temporarily to the storage
    // $filePath = 'tickets/ticket-' . uniqid() . '.pdf';
    // $pdf->save(storage_path('app/public/' . $filePath));

    // // Return the saved file path to be used in the response
    // return $filePath;

    $directoryPath = storage_path('app/public/tickets');
    $fileName = 'ticket-' . uniqid() . '.pdf';
    $filePath = $directoryPath . '/' . $fileName;

    // Check if the directory exists, if not, create it
    if (!file_exists($directoryPath)) {
        mkdir($directoryPath, 0755, true); // Create directory with appropriate permissions
    }

    // Load HTML into PDF and save it to the specified path
    $pdf = Pdf::loadHTML($htmlCode);

    // return response()->json($pdf);
    $pdf->save($filePath);

    // Return the saved file path
    return 'tickets/' . $fileName; 
}

public function RePrintTicket(Request $request)
{
    $validator = Validator::make($request->all(), [
        'headersToken' => 'required|string',
        'headersKey' => 'required|string',
        "bookingRef" => "required|string", 
        "pnr" => "nullable|string"
    ]);     
    
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }
    
    $data = $validator->validated();
    
    $payload = [
        "deviceInfo" => [
            "ip" => "122.161.52.233",
            "imeiNumber" => "12384659878976879887"
        ],
        "bookingRef" => $data['bookingRef'],
        "pnr" => $data["pnr"]
    ];
    
    $headers = [
        'D-SECRET-TOKEN' => $data['headersToken'],
        'D-SECRET-KEY' => $data['headersKey'],
        'CROP-CODE' => 'DOTMIK160614',
        'Content-Type' => 'application/json',
    ];

    // API URL
    $url = 'https://api.dotmik.in/api/flightBooking/v1/rePrintTicket';

    try {
         // Make the POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result=$response->json();

        //    $result=json_decode($res,true);

            $statusCode = $response->status();
            
            if($result['status'] === false)
            {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result
                ],$statusCode);
            }
            else
            {
                if($response->successful())
                {    
                    $PNR= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Airline_PNR'];
                    $Aircraft= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Aircraft_Type'];
                    $Ticket= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['PAXTicketDetails'][0]['TicketDetails'][0]['Ticket_Number'];
                    $Origin_Code= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['PAXTicketDetails'][0]['TicketDetails'][0]['SegemtWiseChanges']['0']['Origin'];
                    $Destination_Code= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['PAXTicketDetails'][0]['TicketDetails'][0]['SegemtWiseChanges']['0']['Destination'];
                    $first= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['PAXTicketDetails'][0]['First_Name'];
                    $last= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['PAXTicketDetails'][0]['Last_Name'];
                    $Origin=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Origin'];
                    $Origin_terminal=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Origin_Terminal'];
                    $ArrivalDateTime=new DateTime($result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Arrival_DateTime']);
                    $DepartureDateTime=new DateTime($result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Departure_DateTime']);
                    $Destination=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Destination'];
                    $Destination_terminal=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Destination_Terminal'];
                    $DurationTime= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Duration'];
                    $type=$result['payloads']['data']['rePrintTicket']['Class_of_Travel'];

                    $Cabin=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['Free_Baggage']['Hand_Baggage'];
                    $CheckIn=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['Free_Baggage']['Check_In_Baggage'];
                    $Gender=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['PAXTicketDetails'][0]['Gender'];
                    $Contact=$result['payloads']['data']['rePrintTicket']['PAX_Mobile'];
                    $Email=$result['payloads']['data']['rePrintTicket']['PAX_EmailId'];
                    $BaseFare=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['Basic_Amount'];
                    
                    $TotalAmount=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['Total_Amount'];

                    $Cancellation=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['CancellationCharges'];

                    $RescheduleCharges=$result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['RescheduleCharges'];

                    $FlightNO = $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Flight_Number'];

                    $AirlineCode = $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Segments']['0']['Airline_Code'];

                    $Tax= $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['AirportTax_Amount'] + $result['payloads']['data']['rePrintTicket']['pnrDetails'][0]['Flights'][0]['Fares'][0]['FareDetails']['0']['Trade_Markup_Amount'] ;
                    

                    // https://api.launcherr.co/api/show/Airline?code=AI

                    $CancelArray=[];
                    
                    foreach($Cancellation as $cancel)
                    {
                        $value = [
                            'DurationFrom' => $cancel['DurationFrom'],
                            'DurationTo' => $cancel['DurationTo'],
                            'value' => ($cancel['ValueType'] === 1) ? 'Non Refundable' : $cancel['Value'],
                        ];
                    
                        $CancelArray[] = $value;
                    }
                    
                    $RescheduleChargesArray=[];
                   
                    foreach($RescheduleCharges as $charges)
                    {
                        $value = [
                            'DurationFrom' => $charges['DurationFrom'],
                            'DurationTo' => $charges['DurationTo'],
                            'value' => ($charges['ValueType'] === 1) ? 'Non Refundable' : $charges['Value'],
                        ];
                    
                        $RescheduleChargesArray[] = $value;
                    }
                    
                    if($Gender === 0)
                    {
                        $gen = 'Male';
                    }
                    elseif ($Gender === 1)
                    {
                        $gen = 'Female';
                    }

                if($type === 0)
                {
                    $flight_type="Ecomony";
                }
                else if($type === 1) //  BUSINESS/ 2- FIRST/ 3- PREMIUM_ECONOMY
                {
                    $flight_type="Business";
                }
                else if($type === 2)
                {
                    $flight_type="First Class";
                }
                else if($type === 3)
                {
                    $flight_type="Premium Ecomomy";
                }
        
                $ArrivalTime = $ArrivalDateTime->format('H:i'); // Outputs '16:25'
                $DepartureTime= $DepartureDateTime->format('H:i');
                $ArrivalDate = $ArrivalDateTime->format('D d M, Y');
                $DepartureDate = $DepartureDateTime->format('D d M, Y');
        
                $dateTime = DateTime::createFromFormat('H:i', $DurationTime);
        
                // Extract hours and minutes
                $hours = $dateTime->format('G'); // 'G' formats hours without leading zeros
                $minutes = $dateTime->format('i'); // 'i' formats minutes with leading zeros
        
                // Format as "1h 05m"
                $Duration = $hours . 'h ' . $minutes . 'm';
        
                // Generate the PDF
                $pdfFilePath = $this->generateTicketPdf($Origin,$Origin_terminal,$Origin_Code,$Destination,$Destination_Code,$Destination_terminal,$first,$last,$PNR,$Ticket, $ArrivalTime,$DepartureTime,$ArrivalDate,$DepartureDate,$flight_type,$Duration,$Aircraft,$Cabin,$CheckIn,$gen,$Contact, $Email, $BaseFare, $TotalAmount, $CancelArray, $RescheduleChargesArray,  $FlightNO,$AirlineCode, $Tax);
        
                return response()->json([
                    'success' => true,
                    'pdf_url' => asset('storage/' . $pdfFilePath), // Return the URL for the PDF file
                    'data' => $result,
                ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
        // Assume successful response from the API
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }   
}

    public function Cancellation(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
            "bookingRef" => "required|string", 
            "pnr" => "required|string",
            "FlightId" => "required|string",
            "PassengerId" => "required|string",
            "SegmentId" => "required|string",
            "cancelType" => "required|string", //0-Normal Cancel, 1-Full Refund, 2-No Show
            "cancelCode" => "required|string",
            "remark" => "required|string"
                
        ]);     
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
            
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
        
            return response()->json([
                'success' => false,
                'message' => $formattedErrors[0]
            ], 422);
        }
        
        $data = $validator->validated();
        
        $payload = [
            "deviceInfo"=> [
              "ip"=> "122.161.52.233",
              "imeiNumber" => "12384659878976879887"
            ],
            "ticketCancelDetails" => [
              [
                  "FlightId" => $data['FlightId'],
                  "PassengerId" => $data["PassengerId"],
                  "SegmentId" => $data["SegmentId"]
              ]
            ],
            "pnr" => $data["pnr"],
            "bookingRef" => $data["bookingRef"],
            "cancelType" => $data["cancelType"], //0-Normal Cancel, 1-Full Refund, 2-No Show
            "cancelCode" => $data["cancelCode"],
            "remark" => $data["remark"]
            
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'] ?? '', // Use null coalescing to avoid issues
            'D-SECRET-KEY' => $data['headersKey'] ?? '', // Same for the key
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];
               
        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/cancellation';

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
                    ], $statusCode);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }   
    }


    public function LowFare(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
             "origin" => "required|string",
            "destination" => "required|string",
            "month" => "required|string",
            "year" => "required|string",
        ]);     

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
    
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
    
            return response()->json([
                'success' => false,
                'error' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879887"
            ],
            "origin" => $data['origin'],
            "destination" => $data['destination'],
            "month" => $data["month"],
            "year" => $data["year"]
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/lowFare';

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
                    ], $statusCode);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }   
    }

    public function SectorAvalability(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
        ]);     

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
    
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
    
            return response()->json([
                'success' => false,
                'message' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879887"
            ]
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/sectorAvailabilityPi';

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
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }   
    }

    public function ReleasePNR(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
            "travelType" => "required|string",
            "bookingType" => "required|string",
            "origin" => "required|string",
            "destination" => "required|string",
            "travelDate" => "required|date",
            "tripId" => "required|string",
            "adultCount" => "required|string",
            "childCount" => "required|string",
            "infantCount" => "required|string",
            "classOfTravel" => "required|string",
        ]);     

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); // Get all error messages
            $formattedErrors = [];
    
            foreach ($errors as $error) {
                $formattedErrors[] = $error;
            }
    
            return response()->json([
                'success' => false,
                'messsage' => $formattedErrors[0]
            ], 422);
        }
        
        $data=$validator->validated();

        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879887"
            ],
            "travelType" => $data['travelType'], // Domestic or International
            "bookingType" => $data['bookingType'], // One way
            "tripInfo" => [
                "origin" => $data['origin'],
                "destination" => $data['destination'],
                "travelDate" => $data['travelDate'], // MM/DD/YYYY
                "tripId" => $data['tripId'] // Ongoing trip
            ],
            "adultCount" => $data['adultCount'],
            "childCount" => $data['childCount'],
            "infantCount" => $data['infantCount'],
            "classOfTravel" => $data['classOfTravel'],// This requires the class of Travel. Possible values: 0- ECONOMY/ 1- BUSINESS/ 2- FIRST/ 3- PREMIUM_ECONOMY
        ];

        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/releasePnr';

        try {
            // Make the POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            $result=$response->json();
            $statusCode = $response->status();

            if($result['status'] === false)
            {
                return response()->json([
                    'success' => 0,
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
                        'message' => $result['message'],
                        'error' => $result
                    ],$statusCode);
                }
            }
            //code...
        } catch  (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 500);
        }   
    }   
}


        // $validator = Validator::make($request->all(), [
        //     'mobile' => 'required|string',
        //     'whatsApp' => 'required|string',
        //     'email' => 'required|string',
        //     // 'passenger_details.paxId' => 'required|integer',
        //     // 'passenger_details.paxType' => 'required|integer', // 0-ADT/1-CHD/2-INF
        //     // 'passenger_details.title' => 'required|string',   // MR, MRS, MS; MSTR, MISS for child/infant
        //     // 'passenger_details.firstName' => 'required|string',
        //     // 'passenger_details.lastName' => 'required|string',
        //     // 'passenger_details.age' => 'nullable|integer',
        //     // 'passenger_details.gender' => 'required|integer',  // 0-Male, 1-Female
        //     // 'passenger_details.dob' => 'required|date',
        //     // 'passenger_details.passportNumber' => 'nullable|string',
        //     // 'passenger_details.passportIssuingAuthority' => 'required|string',
        //     // 'passenger_details.passportExpire' => 'required|date',
        //     // 'passenger_details.nationality' => 'required|string',
        //     // 'passenger_details.pancardNumber' => 'nullable|string',
        //     // 'passenger_details.frequentFlyerDetails' => 'nullable|string',
        //     'passenger_details' => 'required|array',  // Ensure it's an array
        //     'passenger_details.*.paxId' => 'required|integer',
        //     'passenger_details.*.paxType' => 'required|integer|in:0,1,2', // 0-ADT, 1-CHD, 2-INF
        //     'passenger_details.*.title' => [
        //         'required',
        //         'string',
        //         function($attribute, $value, $fail) {
        //             $paxType = request()->input(str_replace('.title', '.paxType', $attribute));
        //             if ($paxType == 0 && !in_array($value, ['Mr', 'Mrs', 'Ms'])) {
        //                 $fail("The {$attribute} must be one of Mr, Mrs, or Ms for adults.");
        //             } elseif (in_array($paxType, [1, 2]) && !in_array($value, ['MSTR', 'MISS'])) {
        //                 $fail("The {$attribute} must be one of MSTR or MISS for children/infants.");
        //             }
        //         }
        //     ],
        //     'passenger_details.*.firstName' => 'required|string',
        //     'passenger_details.*.lastName' => 'required|string',
        //     'passenger_details.*.age' => 'nullable|integer',
        //     'passenger_details.*.gender' => 'required|integer|in:0,1',  // 0-Male, 1-Female
        //     'passenger_details.*.dob' => 'required|date',
        //     'passenger_details.*.passportNumber' => 'nullable|string',
        //     'passenger_details.*.passportIssuingAuthority' => 'required|string',
        //     'passenger_details.*.passportExpire' => 'required|date',
        //     'passenger_details.*.nationality' => 'required|string',
        //     'passenger_details.*.pancardNumber' => 'nullable|string',
        //     'passenger_details.*.frequentFlyerDetails' => 'nullable|string',
        //     'gst.isGst' => 'required|string',
        //     'gst.gstNumber' => 'nullable|string',
        //     'gst.gstName' => 'nullable|string',
        //     'gst.gstAddress' => 'nullable|string',
        //     'searchKey' => 'required|string',
        //     'FlightKey' => 'required|string',
        //     'headersToken' => 'required|string',
        //     'headersKey' => 'required|string'
        // ]);
        
        // if ($validator->fails()) {
        //     $errors = $validator->errors()->all();
        //     return response()->json([
        //         'success' => false,
        //         'message' => $errors[0] // Return the first error
        //     ], 422);
        // }
        
        // $data = $validator->validated();


        // // return response()->json($data['passenger_details']['mobile']);

        // $payload = [
        //     "deviceInfo" => [
        //         "ip" => "122.161.52.233",
        //         "imeiNumber" => "12384659878976879887"
        //     ],
        //     "passengers" => [
        //         "mobile" => $data['mobile'],
        //         "whatsApp" => $data['whatsApp'],
        //         "email" => $data['email'],
        //         "paxDetails" => array_map(function ($passenger) {
        //             return [
        //                 "paxId" => $passenger['paxId'],
        //                 "paxType" => $passenger['paxType'],
        //                 "title" => $passenger['title'],
        //                 "firstName" => $passenger['firstName'],
        //                 "lastName" => $passenger['lastName'],
        //                 "gender" => $passenger['gender'],
        //                 "age" => $passenger['age'] ?? null,
        //                 "dob" => $passenger['dob'],
        //                 "passportNumber" => $passenger['passportNumber'],
        //                 "passportIssuingAuthority" => $passenger['passportIssuingAuthority'],
        //                 "passportExpire" => $passenger['passportExpire'],
        //                 "nationality" => $passenger['nationality'],
        //                 "pancardNumber" => $passenger['pancardNumber'] ?? null,
        //                 "frequentFlyerDetails" => $passenger['frequentFlyerDetails'] ?? null
        //             ];
        //         }, $data['passenger_details']) // map each passenger
        //     ],
        //     "gst" => [
        //         "isGst" => $data['gst']['isGst'],
        //         "gstNumber" => $data['gst']['gstNumber'],
        //         "gstName" => $data['gst']['gstName'],
        //         "gstAddress" => $data['gst']['gstAddress']
        //     ],
        //     "flightDetails" => [
        //         [
        //             "searchKey" => $data['searchKey'],
        //             "flightKey" => $data['FlightKey'],
        //             "ssrDetails" => [] // Empty SSR details
        //         ]
        //     ],
        //     "costCenterId" => 0,
        //     "projectId" => 0,
        //     "bookingRemark" => "Test booking with PAX details",
        //     "corporateStatus" => 0,
        //     "corporatePaymentMode" => 0,
        //     "missedSavingReason" => null,
        //     "corpTripType" => null,
        //     "corpTripSubType" => null,
        //     "tripRequestId" => null,
        //     "bookingAlertIds" => null
        // ];
        
        // // Headers
        // $headers = [
        //     'D-SECRET-TOKEN' => $data['headersToken'],
        //     'D-SECRET-KEY' => $data['headersKey'],
        //     'CROP-CODE' => 'DOTMIK160614',
        //     'Content-Type' => 'application/json',
        // ];
        
        // // API URL
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/tempBooking';
        
        // try {
        //     // Make POST request
        //     $response = Http::withHeaders($headers)->post($url, $payload);
        //     $result = $response->json();
        //     $statusCode = $response->status();
            

        //     if ($result['status'] === false) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => $result['message'],
        //             'error' => $result
        //         ],$statusCode);
        //     } else {
        //         if ($response->successful()) {
        //             return response()->json([
        //                 'success' => true,
        //                 'data' => $result,
        //             ], $statusCode);
        //         } else {
        //             return response()->json([
        //                 'success' => false,
        //                 'message' => $result['message'],
        //                 'error' => $result
        //             ],$statusCode);
        //         }
        //     }
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage()
        //     ], 500);
        // }        



// $validator = Validator::make($request->all(), [
//     "origin" => "required|string",
//     "destination" => "required|string",
//     "travelDate" => "required|date_format:m/d/Y", // Date format should be MM/DD/YYYY
//     "returnTravelDate" => "nullable|date_format:m/d/Y", // New field for return date
//     "travelType" => "required|in:0,1", // 0 for domestic and 1 for international
//     "bookingType" => "required|in:0,1", // 0 for one way, 1 for round trip
//     "adultCount" => "required|integer|min:0", // Change to integer for counts
//     "childCount" => "required|integer|min:0",
//     "infantCount" => "required|integer|min:0",
//     "classOfTravel" => "required|in:0,1,2,3", // Possible values: 0-ECONOMY/1-BUSINESS/2-FIRST/3-PREMIUM_ECONOMY
//     "airlineCode" => "nullable|string",

//     // for Header  
//     "headersToken" => "required|string",
//     "headersKey" => "required|string",

//     // for Filter
//     "Refundable" => "nullable|boolean",
//     'Arrival' => 'nullable|string',
//     'Departure' => 'nullable|string',
// ]);

// // Custom validation rules based on bookingType


// $validator->after(function ($validator) use ($request) {

//     $bookingType = $request->input('bookingType');

//     // return response()->json($boo);

// //             if ($bookingType === "0") {
// //                 // Additional validation for bookingType 0
// // /            }
// //  else
// if ($bookingType == "1") {
//         // Additional validation for bookingType 1
//         // $tripInfo = $request->input('tripInfo');
//         // if (is_array($tripInfo)) {
//         //     foreach ($tripInfo as $key => $trip) {
//         //         if (!isset($trip['origin']) || !isset($trip['destination']) || !isset($trip['travelDate']) || !isset($trip['tripId'])) {
//         //             $validator->errors()->add("tripInfo.$key", 'Each trip in tripInfo must have origin, destination, travelDate, and tripId.');
//         //         }
//         //     }
//         //     if (!$request->has('returnTravelDate')) {
//         //         $validator->errors()->add('returnTravelDate', 'returnTravelDate is required for bookingType 1.');
//         //     }
//         // } else {
//         // if()
//         //     $validator->errors()->add('tripInfo must be an array for bookingType 1.');
//         // }
//         if (!$request->has('returnTravelDate')) {
//             $validator->errors()->add('returnTravelDate', 'returnTravelDate is required for bookingType 1.');
//         }
//     }
// });

// if ($validator->fails()) {
//     $errors = $validator->errors()->all(); // Get all error messages
//     $formattedErrors = [];

//     foreach ($errors as $error) {
//         $formattedErrors[] = $error;
//     }

//     return response()->json([
//         'success' => false,
//         'message' => $formattedErrors[0]
//     ], 422);
// }

// $data = $validator->validated();

// // Prepare the payload based on bookingType
// $payload = [
//     "deviceInfo" => [
//         "ip" => "122.161.52.233",
//         "imeiNumber" => "12384659878976879888"
//     ],
//     "travelType" => $data['travelType'], // 0 for domestic, 1 for international
//     "bookingType" => $data['bookingType'], // 0 for one way, 1 for round trip
//     "tripInfo" => $data['bookingType'] === "1" ? [
//         [
//             "origin" => $data['origin'],
//             "destination" => $data['destination'],
//             "travelDate" => $data['travelDate'],
//             "tripId" => "0" // For the first trip
//         ],
//         [
//             "origin" => $data['destination'], // Reverse trip
//             "destination" => $data['origin'],
//             "travelDate" => $data['returnTravelDate'], // Use return date if provided
//             "tripId" => "1" // For return trip
//         ]
//     ] : [
//             "origin" => $data['origin'],
//             "destination" => $data['destination'],
//             "travelDate" => $data['travelDate'],
//             "tripId" => "0" // Ongoing trip
//     ],
//     "adultCount" => $data['adultCount'],
//     "childCount" => $data['childCount'],
//     "infantCount" => $data['infantCount'],
//     "classOfTravel" => $data['classOfTravel'], // Possible values: 0-ECONOMY/1-BUSINESS/2-FIRST/3-PREMIUM_ECONOMY
//     "filteredAirLine" => [
//         "airlineCode" => $data['airlineCode'] ?? ''
//     ]
// ];

// // return response()->json($payload);


// // Headers
// $headers = [
//     'D-SECRET-TOKEN' => $data['headersToken'],
//     'D-SECRET-KEY' => $data['headersKey'],
//     'CROP-CODE' => 'DOTMIK160614',
//     'Content-Type' => 'application/json',
// ];


// // API URL
// $url = 'https://staging.dotmik.in/api/flightBooking/v1/searchFlight';
