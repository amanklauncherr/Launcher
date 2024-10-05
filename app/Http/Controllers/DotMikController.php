<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
                'success' => 0,
                'error' => $formattedErrors[0]
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
                return response()->json($result,$statusCode);   
            }
            else
            {   
                if ($response->successful()) 
                {
                    $dataa = $result['payloads']['data']['tripDetails'];
                    
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
                    
                    // Output the array structure to see the JSON-like format
                    // echo json_encode($payloads, JSON_PRETTY_PRINT);
                    

                    return response()->json([
                        'status' => true,
                        'count' => $count,
                        'status_code' => $result['status_code'],
                        'request_id' => $result['request_id'],
                        'SearchKey' => $result['payloads']['data']['searchKey'],
                        'AirlineCodes' =>  $distinctAirlineCodes,
                        'payloads' => $payloads,
                        // 'data' => $filtered,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to fetch flight data',
                        'error' => $response->json()
                    ], $response->status());
                }
            }
        } catch (\Exception $e) {
            // Handle exception (e.g. network issues)
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
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
                'success' => 0,
                'error' => $formattedErrors[0]
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
                'success' => 0,
                'error' => $formattedErrors[0]
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

    public function TemporaryBooking(Request $request){
        $validator = Validator::make($request->all(), [
            'passenger_details.mobile' => 'required|string',
            'passenger_details.whatsApp' => 'required|string',
            'passenger_details.email' => 'required|string',
            'passenger_details.paxId' => 'required|integer',
            'passenger_details.paxType' => 'required|integer', // 0-ADT/1-CHD/2-INF
            'passenger_details.title' => 'required|string',   // MR, MRS, MS; MSTR, MISS for child/infant
            'passenger_details.firstName' => 'required|string',
            'passenger_details.lastName' => 'required|string',
            'passenger_details.age' => 'nullable|integer',
            'passenger_details.gender' => 'required|integer',  // 0-Male, 1-Female
            'passenger_details.dob' => 'required|date',
            'passenger_details.passportNumber' => 'required|string',
            'passenger_details.passportIssuingAuthority' => 'required|string',
            'passenger_details.passportExpire' => 'required|date',
            'passenger_details.nationality' => 'required|string',
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
                'success' => 0,
                'error' => $errors[0] // Return the first error
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
                return response()->json($result, $statusCode);
            } else {
                if ($response->successful()) {
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
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
                'success' => 0,
                'error' => $formattedErrors[0]
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

    public function History(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'headersToken' => 'required|string',
            'headersKey' => 'required|string',
            "fromDate" => "required|string", //date in (MM/dd/YYYY)
            "toDate" => "required|string",  //date in (MM/dd/YYYY)
            "month" => "required|string", // Month of booking for July (eg: 07)
            "year" => "required|string", //year of booking(eg:2024)
            "type" => "required|string" //Possible values are 0 - BOOKING_DATE/ 1 - BOOKING_DATE_LIVE/ 2 - BOOKING_DATE_CANCELLED/ 3-BLOCKED
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
            "deviceInfo" => [
                "ip" => "122.161.52.233",
                "imeiNumber" => "12384659878976879887"
            ],
            "fromDate" => $data['fromDate'], //date in (MM/dd/YYYY)
            "todate" => $data['toDate'],  //date in (MM/dd/YYYY)
            "month" => $data['month'], // Month of booking for July (eg: 07)
            "year" => $data['year'], //year of booking(eg:2024)
            "type" => $data['type'] //
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        $url = 'https://api.dotmik.in/api/flightBooking/v1/history';

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

    public function RePrintTicket(Request $request)
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
                'success' => 0,
                'error' => $formattedErrors[0]
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
        $url = 'https://api.dotmik.in/api/flightBooking/v1/rePrintTicket';

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

    public function Cancellation(Request $request)
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
                'success' => 0,
                'error' => $formattedErrors[0]
            ], 422);
        }
        
        $data = $validator->validated();
        
        $payload = [
            "deviceInfo" => [
                "ip" => "122.161.52.233", // Keep this static or dynamically assign if needed
                "imeiNumber" => "12384659878976879887" // Static for now
            ],
            "travelType" => $data['travelType'] ?? '0', // Default to '0' (Domestic)
            "bookingType" => $data['bookingType'] ?? '0', // Default to '0' (One way)
            "tripInfo" => [
                "origin" => $data['origin'] ?? 'Unknown Origin', // Provide a default value
                "destination" => $data['destination'] ?? 'Unknown Destination', // Default value
                "travelDate" => $data['travelDate'] ?? now()->format('m/d/Y'), // Provide a default date
                "tripId" => $data['tripId'] ?? '0' // Default trip ID
            ],
            "adultCount" => $data['adultCount'] ?? '1', // Default to 1
            "childCount" => $data['childCount'] ?? '0', // Default to 0
            "infantCount" => $data['infantCount'] ?? '0', // Default to 0
            "classOfTravel" => $data['classOfTravel'] ?? '0' // Default to '0' (Economy)
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
                'success' => 0,
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
                'success' => 0,
                'error' => $formattedErrors[0]
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
                'success' => 0,
                'error' => $formattedErrors[0]
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
    
    

}
