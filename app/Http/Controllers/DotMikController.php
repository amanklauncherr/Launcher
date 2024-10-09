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
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/searchFlight';

        try {
            // Make the POST request using Laravel HTTP Client
            // $response = Http::withHeaders($headers)->post($url, $payload);
            $statusCode = 200;

            $RESULT='{
                "status": true,
                "count": 29,
                "status_code": "TXN",
                "request_id": "NjcwNjM1Nzk2ZjNhZDIwMjQtMTAtMDkgMTM6MTk6MTM=",
                "SearchKey": "H57AktB7T99mWtGWfEypq85F+HF2HAx7+Okb0TT92Q3CMJrqgGWLlQMZCgYr+BYBcOsV7dxyvXeO8IgufRjusMGXs7MH9XPMbm3BS2jDw8vrxF5Ry1tuR8CvVz9ksRmGaySAMZLK1x7I1Aj1WxWICgkjaQzCIMmns7V7oGsJFmj1S0rMhXwMoF9CcapjhHe+t/+Dd9+ooT1/x94pAptDCVwvENFZmujwAyIG+mHR1a0xDuQcCyD1wYsFKus3Iv6hdLwLq75ODKo8vA+sm3A2PYfwHplIc6Cny3C8EdaZ/PgrgUtlppQOcAh6V1YMEqM2tR4tXOMQuSAqE2iVy/G+BG85qLVm+7bSVKE0EDXxw0tmsWnNnzlTKKDARTcT0Xm5DrhizxDri4qjznkuvAPs80be2Lfjrhyl8sCgv/WOMgHVl89flPqiQKd+a/DIpBN/EimTLeYIJZ5GX7c03+e9brk47dgVrPAOdStdUDDRJnkYQSz9JIj0poPKmmZVfifiqZP8c06Nlcdobr9iddnrNecSG/2RQAczNjsOf5uZY2En/ov+B6GrFSKBFgXk2pMfJpazCkeX19+QjnQ9Hl97Iok5XGu4c8H6aKmHnrkwWGenIevnu4QH0cpjAzQauCrQCSmLxaZ6HktsRaKHAB4sL3jtXt7pTbcOjppo/GxFVG3NlIsTjVP1eC5mtqLGHEqpOGBDT0SukpixYD/p/gNBITq4XBn0Zrw0ODAs/maYQhI=",
                "AirlineCodes": [
                    "AI",
                    "6E"
                ],
                "payloads": {
                    "errors": [],
                    "data": {
                        "tripDetails": [
                            {
                                "Flights": [
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1501,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 268,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 160,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5184,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "V",
                                                                "FareBasis": "VU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 6789,
                                                        "Trade_Markup_Amount": 104,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "V4853652766814382298",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "V",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1501,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 268,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 160,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5184,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "VU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 104,
                                                        "Net_Commission": 104,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 6789,
                                                        "Trade_Markup_Amount": 104,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "V5736879062181749299",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "V",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1503,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 270,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 160,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5228,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "VU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 131,
                                                        "Net_Commission": 131,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 3,
                                                        "Total_Amount": 6836,
                                                        "Trade_Markup_Amount": 105,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "V5661750576469505223",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "V",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5184186127799212463",
                                        "Flight_Key": "FK5731146919281156694$FK5375414332406508094$FK4952046481639266650",
                                        "Flight_Numbers": "2618-12/15/2024 15:20",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 16:25",
                                                "Departure_DateTime": "12/15/2024 15:20",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "01:05",
                                                "Flight_Number": "2618",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2207,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 804,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15750,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "LU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 394,
                                                        "Net_Commission": 394,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 18272,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W4786363778074337230",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "L",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4908640755736769333",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 315,
                                                        "Net_Commission": 315,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 6,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5649940142556489036",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4814219606960011763",
                                        "Flight_Key": "FK5191399503441095696$FK5444614791437671456$FK4750773341737867318",
                                        "Flight_Numbers": "2620,2984-12/15/2024 14:55,12/16/2024 01:20",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 03:35",
                                                "Departure_DateTime": "12/16/2024 01:20",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "2984",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2207,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 804,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15750,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "LU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 394,
                                                        "Net_Commission": 394,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 18272,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5064104652564743503",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "L",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5195597158555853500",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 315,
                                                        "Net_Commission": 315,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 6,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5597975492824087324",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4968142598699108308",
                                        "Flight_Key": "FK5104459399027695788$FK5415500963291646141$FK4748011325151357388",
                                        "Flight_Numbers": "2620,859-12/15/2024 14:55,12/16/2024 01:30",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 03:45",
                                                "Departure_DateTime": "12/16/2024 01:30",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "859",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2207,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 804,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15750,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "LU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 394,
                                                        "Net_Commission": 394,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 18272,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W4855750339171494912",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "L",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5707824393096328061",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 315,
                                                        "Net_Commission": 315,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 6,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4888237190902378648",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5032157931295526100",
                                        "Flight_Key": "FK5010208868382368639$FK5162554380751212439$FK5195356461370383704",
                                        "Flight_Numbers": "2620,2954-12/15/2024 14:55,12/16/2024 05:55",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "321",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 08:05",
                                                "Departure_DateTime": "12/16/2024 05:55",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:10",
                                                "Flight_Number": "2954",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2207,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 804,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15750,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "LU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 394,
                                                        "Net_Commission": 394,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 18272,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W4946941144073330528",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "L",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5755257532510637667",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 315,
                                                        "Net_Commission": 315,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 6,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5646304090598069456",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5344035247564334945",
                                        "Flight_Key": "FK5286332263985909325$FK5038569968819960078$FK5016269988103204034",
                                        "Flight_Numbers": "2620,2994-12/15/2024 14:55,12/16/2024 10:25",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 12:40",
                                                "Departure_DateTime": "12/16/2024 10:25",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "2994",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "L",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5286141708417466146",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2208,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 805,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15770,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "L",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "LU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 315,
                                                        "Net_Commission": 315,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 6,
                                                        "Total_Amount": 18293,
                                                        "Trade_Markup_Amount": 315,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5349485047048084296",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5369445595751703379",
                                        "Flight_Key": "FK5681167742463888590$FK5174538870588254731",
                                        "Flight_Numbers": "2620,2944-12/15/2024 14:55,12/16/2024 14:40",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 16:55",
                                                "Departure_DateTime": "12/16/2024 14:40",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "2944",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2273,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 870,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 17063,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 427,
                                                        "Net_Commission": 427,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 9,
                                                        "Total_Amount": 19677,
                                                        "Trade_Markup_Amount": 341,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5092523975705217724",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2275,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 872,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 17110,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 19727,
                                                        "Trade_Markup_Amount": 342,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5333004359867164038",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2275,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 872,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 17110,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 342,
                                                        "Net_Commission": 342,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 7,
                                                        "Total_Amount": 19727,
                                                        "Trade_Markup_Amount": 342,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5009750878945701152",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5421672401503427467",
                                        "Flight_Key": "FK5338623298806403664$FK5549290280442716972$FK5588778279317806473",
                                        "Flight_Numbers": "2620,2928-12/15/2024 14:55,12/16/2024 06:30",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 08:40",
                                                "Departure_DateTime": "12/16/2024 06:30",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:10",
                                                "Flight_Number": "2928",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2297,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 894,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 17541,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 439,
                                                        "Net_Commission": 439,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 9,
                                                        "Total_Amount": 20189,
                                                        "Trade_Markup_Amount": 351,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5539443676993542505",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2300,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 897,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 17598,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXYII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 20250,
                                                        "Trade_Markup_Amount": 352,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5658632458929767975",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2300,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 897,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 17598,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXYII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 352,
                                                        "Net_Commission": 352,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 7,
                                                        "Total_Amount": 20250,
                                                        "Trade_Markup_Amount": 352,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4822443137279365973",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5317445048242261157",
                                        "Flight_Key": "FK5146019739899390962$FK5036225100139885099$FK5727132359718701833",
                                        "Flight_Numbers": "2620,9485-12/15/2024 14:55,12/16/2024 00:40",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "737",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 02:55",
                                                "Departure_DateTime": "12/16/2024 00:40",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "9485",
                                                "Leg_Index": 0,
                                                "OperatedBy": "Air India Express",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "T",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5318702653282577763",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 374,
                                                        "Net_Commission": 374,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 7,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5249973164445158884",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2358,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 955,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18766,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "TU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 469,
                                                        "Net_Commission": 469,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 9,
                                                        "Total_Amount": 21499,
                                                        "Trade_Markup_Amount": 375,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "Q5598297363421016626",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5209594193057269328",
                                        "Flight_Key": "FK5177012420914296813$FK5113025749759110552$FK5314203091312298026",
                                        "Flight_Numbers": "2616,804-12/15/2024 15:40,12/16/2024 05:45",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 08:45",
                                                "Departure_DateTime": "12/16/2024 05:45",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "03:00",
                                                "Flight_Number": "804",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "T",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5042039140439078315",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 374,
                                                        "Net_Commission": 374,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 7,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5028408698231509693",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2358,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 955,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18766,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "TU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 469,
                                                        "Net_Commission": 469,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 9,
                                                        "Total_Amount": 21499,
                                                        "Trade_Markup_Amount": 375,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "Q5719262203284852605",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5763974554611206260",
                                        "Flight_Key": "FK4733462915289864421$FK5482971608845831113$FK4888156529885605634",
                                        "Flight_Numbers": "2616,505-12/15/2024 15:40,12/16/2024 09:50",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 12:45",
                                                "Departure_DateTime": "12/16/2024 09:50",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:55",
                                                "Flight_Number": "505",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "T",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q4838770709456823128",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 374,
                                                        "Net_Commission": 374,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 7,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5229453400142694803",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2358,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 955,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18766,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "TU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 469,
                                                        "Net_Commission": 469,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 9,
                                                        "Total_Amount": 21499,
                                                        "Trade_Markup_Amount": 375,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "Q4774608603105773255",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4787892488720698471",
                                        "Flight_Key": "FK4832022413804398505$FK5060009987701776053$FK5625805296293120883",
                                        "Flight_Numbers": "2616,507-12/15/2024 15:40,12/16/2024 12:20",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "359",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 15:10",
                                                "Departure_DateTime": "12/16/2024 12:20",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:50",
                                                "Flight_Number": "507",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "T",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q4806671699433343872",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2356,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 953,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18720,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 374,
                                                        "Net_Commission": 374,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 7,
                                                        "Total_Amount": 21450,
                                                        "Trade_Markup_Amount": 374,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q4844055286614026348",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5545816117334929992",
                                        "Flight_Key": "FK5151044519427524691$FK5547384137822404387",
                                        "Flight_Numbers": "2616,503-12/15/2024 15:40,12/16/2024 17:15",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 20:15",
                                                "Departure_DateTime": "12/16/2024 17:15",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "03:00",
                                                "Flight_Number": "503",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2362,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 959,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18843,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "T",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 21582,
                                                        "Trade_Markup_Amount": 377,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q4880453112462056454",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2362,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 959,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18843,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 377,
                                                        "Net_Commission": 377,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 21582,
                                                        "Trade_Markup_Amount": 377,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5677294737621332305",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2365,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 962,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 18892,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "TU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 472,
                                                        "Net_Commission": 472,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 9,
                                                        "Total_Amount": 21635,
                                                        "Trade_Markup_Amount": 378,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "Q5257860577389020958",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5406116788109172861",
                                        "Flight_Key": "FK5574409700871575397$FK4987614945924662599$FK4760704051955274847",
                                        "Flight_Numbers": "2616,509-12/15/2024 15:40,12/15/2024 19:30",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 22:30",
                                                "Departure_DateTime": "12/15/2024 19:30",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "03:00",
                                                "Flight_Number": "509",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2371,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 968,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19028,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "T",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 21780,
                                                        "Trade_Markup_Amount": 381,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q4905843946939567568",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2371,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 968,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19028,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "TU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 381,
                                                        "Net_Commission": 381,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 21780,
                                                        "Trade_Markup_Amount": 381,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5319250170735472071",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2374,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 971,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19081,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "T",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "TU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 477,
                                                        "Net_Commission": 477,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 21837,
                                                        "Trade_Markup_Amount": 382,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "Q5435287307798262137",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4991222365850423209",
                                        "Flight_Key": "FK5644890810038366246$FK5217302917475592575$FK5035187966282712599",
                                        "Flight_Numbers": "2616,808-12/15/2024 15:40,12/15/2024 21:00",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 23:55",
                                                "Departure_DateTime": "12/15/2024 21:00",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:55",
                                                "Flight_Number": "808",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2405,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1002,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19709,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 493,
                                                        "Net_Commission": 493,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22508,
                                                        "Trade_Markup_Amount": 394,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5035031707772164005",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2410,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1007,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19810,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 22616,
                                                        "Trade_Markup_Amount": 396,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5150379330624914886",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2410,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1007,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19810,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 396,
                                                        "Net_Commission": 396,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 22616,
                                                        "Trade_Markup_Amount": 396,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5640541990165744722",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4688047116698162495",
                                        "Flight_Key": "FK5305737151391791380$FK5464252221017684550$FK5668940575807366135",
                                        "Flight_Numbers": "2620,2408-12/15/2024 14:55,12/15/2024 19:10",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "321",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 21:15",
                                                "Departure_DateTime": "12/15/2024 19:10",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:05",
                                                "Flight_Number": "2408",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2405,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1002,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19709,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 493,
                                                        "Net_Commission": 493,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22508,
                                                        "Trade_Markup_Amount": 394,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5293838555620445642",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2410,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1007,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19810,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 22616,
                                                        "Trade_Markup_Amount": 396,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5468132967804500553",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2410,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1007,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19810,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 396,
                                                        "Net_Commission": 396,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 22616,
                                                        "Trade_Markup_Amount": 396,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5484492967376736909",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4828676878692029687",
                                        "Flight_Key": "FK4617230916349757504$FK5428546311377725032$FK5368864717564087072",
                                        "Flight_Numbers": "2620,2950-12/15/2024 14:55,12/15/2024 21:55",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 00:10",
                                                "Departure_DateTime": "12/15/2024 21:55",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "2950",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2405,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1002,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19709,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 493,
                                                        "Net_Commission": 493,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22508,
                                                        "Trade_Markup_Amount": 394,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5658916537025987519",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2410,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1007,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19810,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 22616,
                                                        "Trade_Markup_Amount": 396,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4712235231764753149",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2410,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1007,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19810,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 396,
                                                        "Net_Commission": 396,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 22616,
                                                        "Trade_Markup_Amount": 396,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4690139494897621750",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5021650253932064673",
                                        "Flight_Key": "FK5559409632818314406$FK5659980977115820324$FK5318332887058655405",
                                        "Flight_Numbers": "2620,2986-12/15/2024 14:55,12/15/2024 22:50",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "321",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/16/2024 01:00",
                                                "Departure_DateTime": "12/15/2024 22:50",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:10",
                                                "Flight_Number": "2986",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2415,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1012,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19903,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 498,
                                                        "Net_Commission": 498,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22716,
                                                        "Trade_Markup_Amount": 398,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W4960146420230175129",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2420,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1017,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20005,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 22825,
                                                        "Trade_Markup_Amount": 400,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5413090496730374459",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2420,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1017,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20005,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 400,
                                                        "Net_Commission": 400,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 22825,
                                                        "Trade_Markup_Amount": 400,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5088897100706251923",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5167172810293548853",
                                        "Flight_Key": "FK4909029424889044165$FK4712746434691907500$FK5722735642628012092",
                                        "Flight_Numbers": "2620,2996-12/15/2024 14:55,12/15/2024 18:30",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "321",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 20:40",
                                                "Departure_DateTime": "12/15/2024 18:30",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:10",
                                                "Flight_Number": "2996",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2415,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1012,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19903,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 498,
                                                        "Net_Commission": 498,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22716,
                                                        "Trade_Markup_Amount": 398,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5228580401642528463",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2420,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1017,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20005,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 22825,
                                                        "Trade_Markup_Amount": 400,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4867711982637100042",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2420,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1017,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20005,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 400,
                                                        "Net_Commission": 400,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 22825,
                                                        "Trade_Markup_Amount": 400,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4761961601551198879",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5173473964043513701",
                                        "Flight_Key": "FK4754170991755576525$FK5385702715713328015$FK5176732279601697739",
                                        "Flight_Numbers": "2620,888-12/15/2024 14:55,12/15/2024 19:00",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 21:15",
                                                "Departure_DateTime": "12/15/2024 19:00",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "888",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2415,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1012,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 19903,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 498,
                                                        "Net_Commission": 498,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22716,
                                                        "Trade_Markup_Amount": 398,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W4884270261013405321",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2420,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1017,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20005,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 22825,
                                                        "Trade_Markup_Amount": 400,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5458231068562353114",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2420,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1017,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20005,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 400,
                                                        "Net_Commission": 400,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 22825,
                                                        "Trade_Markup_Amount": 400,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W4748283577577964226",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "4642517543360335833",
                                        "Flight_Key": "FK5453141809015909336$FK4640130643368914033$FK5464713547904772246",
                                        "Flight_Numbers": "2620,2988-12/15/2024 14:55,12/15/2024 20:40",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 23:00",
                                                "Departure_DateTime": "12/15/2024 20:40",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:20",
                                                "Flight_Number": "2988",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2425,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1022,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20096,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 502,
                                                        "Net_Commission": 502,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 22923,
                                                        "Trade_Markup_Amount": 402,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5480369081916908841",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2430,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1027,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20199,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 23033,
                                                        "Trade_Markup_Amount": 404,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5249256916176547758",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2430,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1027,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20199,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 404,
                                                        "Net_Commission": 404,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 23033,
                                                        "Trade_Markup_Amount": 404,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5557260959772507493",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5191674125838739476",
                                        "Flight_Key": "FK5356260720239593855$FK4848756215157374292$FK4999755207414483793",
                                        "Flight_Numbers": "2620,2940-12/15/2024 14:55,12/15/2024 19:45",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 21:55",
                                                "Departure_DateTime": "12/15/2024 19:45",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:10",
                                                "Flight_Number": "2940",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2430,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1027,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20193,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 505,
                                                        "Net_Commission": 505,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 23027,
                                                        "Trade_Markup_Amount": 404,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "W5140332855794684239",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2435,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1032,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20296,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 23137,
                                                        "Trade_Markup_Amount": 406,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5553644054489334569",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2435,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1032,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20296,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 406,
                                                        "Net_Commission": 406,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 23137,
                                                        "Trade_Markup_Amount": 406,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "W5077467315787875030",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "W",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5248457291301104106",
                                        "Flight_Key": "FK4950746765164116434$FK4978841994539030290$FK5363582306404805581",
                                        "Flight_Numbers": "2620,816-12/15/2024 14:55,12/15/2024 21:00",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 17:25",
                                                "Departure_DateTime": "12/15/2024 14:55",
                                                "Destination": "BOM",
                                                "Destination_City": "MUMBAI",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:30",
                                                "Flight_Number": "2620",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "77W",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 23:15",
                                                "Departure_DateTime": "12/15/2024 21:00",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:15",
                                                "Flight_Number": "816",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BOM",
                                                "Origin_City": "MUMBAI",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2443,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1040,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20453,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "QU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "SPECIAL FARE",
                                                                "FareBasis": "WU1YX7II",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 511,
                                                        "Net_Commission": 511,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 10,
                                                        "Total_Amount": 23305,
                                                        "Trade_Markup_Amount": 409,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 5,
                                                "Fare_Id": "Q5023067697614108719",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2448,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1045,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20570,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Q",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "W",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 12,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 12,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 23429,
                                                        "Trade_Markup_Amount": 411,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q4876429960785188876",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 2448,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 1045,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 330,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 20570,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "Q",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "QU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "W",
                                                                "Class_Desc": "Economy",
                                                                "FareBasis": "WU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 411,
                                                        "Net_Commission": 411,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 8,
                                                        "Total_Amount": 23429,
                                                        "Trade_Markup_Amount": 411,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "Q5033607219302854543",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "Q",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "5",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5128629595727054486",
                                        "Flight_Key": "FK5054873567260580552$FK5446490171676999869$FK5333563426609218909",
                                        "Flight_Numbers": "2616,2818-12/15/2024 15:40,12/15/2024 19:35",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 18:25",
                                                "Departure_DateTime": "12/15/2024 15:40",
                                                "Destination": "BLR",
                                                "Destination_City": "BANGALORE",
                                                "Destination_Terminal": "2",
                                                "Duration": "02:45",
                                                "Flight_Number": "2616",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": null,
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "321",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 22:30",
                                                "Departure_DateTime": "12/15/2024 19:35",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "02:55",
                                                "Flight_Number": "2818",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "BLR",
                                                "Origin_City": "BANGALORE",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "6E",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": true,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1401,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1401,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5514,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "M",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "MMIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 66,
                                                        "Net_Commission": 66,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7025,
                                                        "Trade_Markup_Amount": 110,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "M4925887090577109684",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "M",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "2",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1401,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1401,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5514,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "M",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "M0IP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 66,
                                                        "Net_Commission": 66,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7025,
                                                        "Trade_Markup_Amount": 110,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "R5251893660683089676",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "R",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "2",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1429,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1429,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 6065,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "M",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "MUIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 73,
                                                        "Net_Commission": 73,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7615,
                                                        "Trade_Markup_Amount": 121,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "J5625385709891371698",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "J",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "2",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1476,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1476,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 7014,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "M",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "MLIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "20 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 84,
                                                        "Net_Commission": 84,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 8630,
                                                        "Trade_Markup_Amount": 140,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "O4667860239507174669",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "O",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "2",
                                                "Warning": null
                                            }
                                        ],
                                        "Flight_Id": "5587619442530561930",
                                        "Flight_Key": "FK5273838597472846981",
                                        "Flight_Numbers": "2253-12/15/2024 09:35",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": true,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "320",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 10:25",
                                                "Departure_DateTime": "12/15/2024 09:35",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "2",
                                                "Duration": "00:50",
                                                "Flight_Number": "2253",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "6E",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": true,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1425,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1425,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5994,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "VMIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 72,
                                                        "Net_Commission": 72,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7539,
                                                        "Trade_Markup_Amount": 120,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "M5397339077996548791",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "M",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "3",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1425,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1425,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5994,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "V0IP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 72,
                                                        "Net_Commission": 72,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7539,
                                                        "Trade_Markup_Amount": 120,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "R5351060882585899611",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "R",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "3",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1455,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1455,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 6593,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "VUIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 79,
                                                        "Net_Commission": 79,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 8180,
                                                        "Trade_Markup_Amount": 132,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "J4626396342506645513",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "J",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "3",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1500,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1500,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 7494,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "VLIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "20 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 90,
                                                        "Net_Commission": 90,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 9144,
                                                        "Trade_Markup_Amount": 150,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "O5352637835979296277",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "O",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "3",
                                                "Warning": null
                                            }
                                        ],
                                        "Flight_Id": "5290886449857791359",
                                        "Flight_Key": "FK4767099880559556626",
                                        "Flight_Numbers": "2116-12/15/2024 15:55",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": true,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "320",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 16:45",
                                                "Departure_DateTime": "12/15/2024 15:55",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "2",
                                                "Duration": "00:50",
                                                "Flight_Number": "2116",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "6E",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": true,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1380,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1380,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5081,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "N0IP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 61,
                                                        "Net_Commission": 61,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 6563,
                                                        "Trade_Markup_Amount": 102,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "R5714582520778312049",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "R",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "1",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1380,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1380,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5081,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "NMIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 61,
                                                        "Net_Commission": 61,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 6563,
                                                        "Trade_Markup_Amount": 102,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "M5222969909687997473",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "M",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "1",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1405,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1405,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5589,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "NUIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 67,
                                                        "Net_Commission": 67,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7106,
                                                        "Trade_Markup_Amount": 112,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "J5504761970080931703",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "J",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "1",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1455,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1455,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 6581,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "NLIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "20 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 79,
                                                        "Net_Commission": 79,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 8168,
                                                        "Trade_Markup_Amount": 132,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "O4633794000893030683",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "O",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "1",
                                                "Warning": null
                                            }
                                        ],
                                        "Flight_Id": "4869113236988035742",
                                        "Flight_Key": "FK5582169477139735932",
                                        "Flight_Numbers": "2072-12/15/2024 18:45",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": true,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "320",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 19:35",
                                                "Departure_DateTime": "12/15/2024 18:45",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "2",
                                                "Duration": "00:50",
                                                "Flight_Number": "2072",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "6E",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": true,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1380,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1380,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5081,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "N0IP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 61,
                                                        "Net_Commission": 61,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 6563,
                                                        "Trade_Markup_Amount": 102,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "R5382416768113764968",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "R",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1380,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1380,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5081,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "NMIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 61,
                                                        "Net_Commission": 61,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 6563,
                                                        "Trade_Markup_Amount": 102,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "M5489524264117735321",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "M",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1405,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1405,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5589,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "NUIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 67,
                                                        "Net_Commission": 67,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 7106,
                                                        "Trade_Markup_Amount": 112,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "J4882694546593052788",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "J",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1455,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1455,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 6581,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "N",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "NLIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "20 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 79,
                                                        "Net_Commission": 79,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 8168,
                                                        "Trade_Markup_Amount": 132,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "O5131595181562814911",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "O",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            }
                                        ],
                                        "Flight_Id": "5159284646517222411",
                                        "Flight_Key": "FK5111858353324338341",
                                        "Flight_Numbers": "6581-12/15/2024 19:50",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": true,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "320",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 20:40",
                                                "Departure_DateTime": "12/15/2024 19:50",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "1",
                                                "Duration": "00:50",
                                                "Flight_Number": "6581",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "6E",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": true,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1787,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1787,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 12186,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "R030AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "C",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "C0IP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 146,
                                                        "Net_Commission": 146,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 3,
                                                        "Total_Amount": 14217,
                                                        "Trade_Markup_Amount": 244,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "R5099311498278664682",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "R",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1821,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1821,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 12857,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "RU30AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "C",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "CUIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 154,
                                                        "Net_Commission": 154,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 3,
                                                        "Total_Amount": 14935,
                                                        "Trade_Markup_Amount": 257,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "J5279278192984489554",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "J",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1842,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1842,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 13282,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "RM30AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "C",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "CMIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 159,
                                                        "Net_Commission": 159,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 3,
                                                        "Total_Amount": 15390,
                                                        "Trade_Markup_Amount": 266,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "M5020755820392110387",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "M",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1937,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1937,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 15186,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "RL30AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "C",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "CLIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "20 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 182,
                                                        "Net_Commission": 182,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 4,
                                                        "Total_Amount": 17427,
                                                        "Trade_Markup_Amount": 304,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "O4740503112304546651",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "O",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "4",
                                                "Warning": null
                                            }
                                        ],
                                        "Flight_Id": "4832416582917634872",
                                        "Flight_Key": "FK5466903591336826420",
                                        "Flight_Numbers": "7275,2176-12/15/2024 09:40,12/15/2024 17:15",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": true,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "ATR",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 11:00",
                                                "Departure_DateTime": "12/15/2024 09:40",
                                                "Destination": "JAI",
                                                "Destination_City": "JAIPUR",
                                                "Destination_Terminal": "2",
                                                "Duration": "01:20",
                                                "Flight_Number": "7275",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "320",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 18:20",
                                                "Departure_DateTime": "12/15/2024 17:15",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "2",
                                                "Duration": "01:05",
                                                "Flight_Number": "2176",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "JAI",
                                                "Origin_City": "JAIPUR",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    {
                                        "Airline_Code": "6E",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": true,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1403,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1403,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 4506,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "R030AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Regular",
                                                                "FareBasis": "R0IP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 54,
                                                        "Net_Commission": 54,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 5999,
                                                        "Trade_Markup_Amount": 90,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "R5029972687621578897",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "R",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "15",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1424,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1424,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 4911,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "RM30AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "SME Fare",
                                                                "FareBasis": "RMIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 59,
                                                        "Net_Commission": 59,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 6433,
                                                        "Trade_Markup_Amount": 98,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "M5421100774102810423",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "M",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "15",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1437,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1437,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5177,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "RU30AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Plus",
                                                                "FareBasis": "RUIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 62,
                                                        "Net_Commission": 62,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 1,
                                                        "Total_Amount": 6718,
                                                        "Trade_Markup_Amount": 104,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "J5243777912584449047",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "J",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "15",
                                                "Warning": null
                                            },
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1553,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 1553,
                                                                "Tax_Code": "Tax",
                                                                "Tax_Desc": "Tax"
                                                            },
                                                            {
                                                                "Tax_Amount": 0,
                                                                "Tax_Code": "YQ",
                                                                "Tax_Desc": "YQ"
                                                            }
                                                        ],
                                                        "Basic_Amount": 7506,
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "RL30AP",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            },
                                                            {
                                                                "Class_Code": "R",
                                                                "Class_Desc": "Super 6E",
                                                                "FareBasis": "RLIP",
                                                                "Privileges": null,
                                                                "Segment_Id": 1
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "20 Kg (1 Piece Only)",
                                                            "Hand_Baggage": "7 Kg"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 90,
                                                        "Net_Commission": 90,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 2,
                                                        "Total_Amount": 9209,
                                                        "Trade_Markup_Amount": 150,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "O5469777712765475602",
                                                "Fare_Key": null,
                                                "Food_onboard": null,
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "O",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "15",
                                                "Warning": null
                                            }
                                        ],
                                        "Flight_Id": "4913205680795567863",
                                        "Flight_Key": "FK4679607779567516929",
                                        "Flight_Numbers": "7148,2035-12/15/2024 19:30,12/15/2024 22:35",
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": false,
                                        "InventoryType": 0,
                                        "IsLCC": true,
                                        "Origin": "DED",
                                        "Repriced": false,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "ATR",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 20:50",
                                                "Departure_DateTime": "12/15/2024 19:30",
                                                "Destination": "JAI",
                                                "Destination_City": "JAIPUR",
                                                "Destination_Terminal": "2",
                                                "Duration": "01:20",
                                                "Flight_Number": "7148",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            },
                                            {
                                                "Aircraft_Type": "321",
                                                "Airline_Code": "6E",
                                                "Airline_Name": "IndiGo",
                                                "Arrival_DateTime": "12/15/2024 23:35",
                                                "Departure_DateTime": "12/15/2024 22:35",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "2",
                                                "Duration": "01:00",
                                                "Flight_Number": "2035",
                                                "Leg_Index": 0,
                                                "OperatedBy": "",
                                                "Origin": "JAI",
                                                "Origin_City": "JAIPUR",
                                                "Origin_Terminal": "2",
                                                "Return_Flight": false,
                                                "Segment_Id": 1,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    }
                                ]
                            }
                        ]
                    }
                }
            }';

            
            // return response()->json(json_decode($result));

            $result = json_decode($RESULT, true); // Decode JSON string to associative array

            // if($result['status'] === false)
            // {
            //     return response()->json($result,$statusCode);   
            // }
            // else
            // {   
            //     if ($response->successful()) 
            //     {

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



                    // return response()->json(json_decode($result));

                    // $filtered=json_decode($result);


                    $count = count($filtered);

                    // return response()->json($count);


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
                        'SearchKey' => $result['SearchKey'], //$result['payloads']['data']['searchKey'],
                        'AirlineCodes' =>  $distinctAirlineCodes,
                        'payloads' => $payloads,
                        // 'data' => $filtered,
                    ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
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
            // $response = Http::withHeaders($headers)->post($url, $payload);

            $result= ' {
    "success": true,
    "data": {
        "status": true,
        "status_code": "TXN",
        "request_id": "NjcwNjM2NWU0NTMxZjIwMjQtMTAtMDkgMTM6MjM6MDI=",
        "payloads": {
            "errors": [],
            "data": {
                "fareRules": [
                    {
                        "FareRuleDesc": "<html><head><title></title></head><body><table><tr><td>PENALTIES</td><td>PENALTIES\nUNLESS OTHERWISE SPECIFIED   NOTE - RULE DO16 IN IPRG\nAPPLIES\nFOR &&&YX&&& TYPE FARES\n  CHANGES\n    CHARGE INR 3000 FOR REISSUE/REVALIDATION.\n         NOTE -\n          TILL 02 HRS CHARGE INR 3000 PER COMPONENT FOR\n          REISSUE/REVALIDATION.\n          A CHANGE FEE OF INR 3000 PER COUPON OR BASIC FARE\n          WHICH EVER IS LOWER.\n          --------------------------------------------------\n          CHARGES ARE NON-COMMISISONABLE. APPLICABLE GST\n          WILL BE ADDITIONAL 5 PERCENT GST FOR ALL ECONOMY\n          CLASS 12 PERCENT GST FOR ALL FIRST / BUSINESS\n          CLASS /PREMIUM ECONOMY.\n          --------------------------------------------------\n          CHARGE APPLIES TO ADULT AND CHILD INFANT NOT\n          OCCUPYING A SEAT IS EXEMPTED. CHANGE FEE CHARGES\n          ARE APPLICABLE PER FARE COMPONENT. SUM OF FEES OF\n          ALL CHANGED FARE COMPONENTS WOULD APPLY INCASE OF\n          MULTIPLE FARE COMPONENTS IN A JOURNEY/ITINERARY.\n          --------------------------------------------------\n          EXAMPLE.1 TOTAL FARE CHARGED INR 5000.00 BLR-\n          BOM2000.00 BOM-UDR3000.00 IN THE ABOVE EXAMPLE AS\n          THERE ARE TWO FARE COMPONENTS FC.FC1 BLR-BOM AND\n          FC 2 BOMUDR FOR CHANGE FEES SYSTEM WOULD SUM-UP\n          THE FEES OF EACH FARE COMPONENT.\n          --------------------------------------------------\n          EXAMPLE 2 TOTAL FARE CHARGED INR 4000.00\n          BLR-X/BOM-UDR4000.00 INCASE OF THROUGH FARE AS\n          SHOWN IN THE ABOVE EXAMPLE FOR ANY CHANGE SYSTEM\n          WOULD APPLY THE FEES ONLY ONCE.\n          --------------------------------------------------\n          DOWNSELLING TO A LOWER FARE/BRAND/CABIN IS NOT\n          PERMITTED.\n          --------------------------------------------------\n          IN CASE OF CHANGE TO HIGHER BRAND/CABIN FOR\n          TRAVEL ON THE SAME DAY/SAME FLIGHT/RE-ISSUANCE\n          FEE WILL NOT BE APPLICABLE.ONLY DIFFERENCE IN\n          TOTAL FARE IS TO BE COLLECTED.\n          --------------------------------------------------\n          RE ROUTING IS PERMITTED.\n          --------------------------------------------------\n          THE CHANGE/REISSUE CHARGE IS NON - REFUNDABLE\n  CANCELLATIONS\n    CHARGE INR 4000 FOR CANCEL/REFUND.\n         NOTE -\n          TILL 02 HRS CHARGE INR 4000 PER COMPONENT FOR\n          CANCELLATION.\n          --------------------------------------------------\n          BASE FARE OR CANCELLATION/REFUND FEES WHICHEVER\n          IS LOWER WILL BE DEDUCTED WHEN PROCESSING REFUND.\n          -------------------------------------------------\n          CHARGES ARE NON-COMMISISONABLE. APPLICABLE GST\n          WILL BE ADDITIONAL 5 PERCENT GST FOR ALL ECONOMY\n          CLASS 12 PERCENT GST FOR ALL FIRST / BUSINESS\n          CLASS /PREMIUM ECONOMY.\n          --------------------------------------------------\n          CHARGE APPLIES TO ADULT AND CHILD INFANT NOT\n          THE CANCEL/REFUND CHARGE IS NON - REFUNDABLE\n          OCCUPYING A SEAT IS EXEMPTED. CHANGE FEE CHARGES\n          ARE APPLICABLE PER FARE COMPONENT. SUM OF FEES OF\n          ALL CHANGED FARE COMPONENTS WOULD APPLY INCASE OF\n          MULTIPLE FARE COMPONENTS IN A JOURNEY/ITINERARY.\n          --------------------------------------------------\n          WHEN FARES ARE COMBINED THE MOST RESTRICTIVE\n          CONDITIONS APPLY FOR THE ENTIRE JOURNEY.\n          --------------------------------------------------\n          CANCELLATION/REFUND FEE OF PARTLY USED TICKET\n          DEDUCT ONEWAY FARE AND LEVIES FOR THE TRAVELLED\n          SECTOR PLUS CANCELLATION/REFUND FEE.\n          --------------------------------------------------\n          FARES WHEN COMBINED ON A HALF ROUND TRIP BASIS\n          SHALL BE GOVERNED  BY THE CORRESPONDING\n          APPLICABLE TICKETED FARE PER SECTOR AND ITS\n          APPLICABLE TERMS AND CONDITIONS.\n          --------------------------------------------------\n          OUT OF SEQUENCE TRAVEL NOT PERMITTED FOR THROUGH\n          AND CONNECTION FARES THERE WILL BE NO REFUND FOR\n          OUT OF SEQUENCE COUPON EXCEPT THE STATUTARY TAXES.\n          --------------------------------------------------\n          THE CANCEL/REFUND CHARGE IS NON - REFUNDABLE\n          --------------------------------------------------\n    TICKET IS NON-REFUNDABLE IN CASE OF NO-SHOW.\n         NOTE -\n          100 PERCENT OF BASIC FARE WILL BE FORFEITED.\n          ---------------------------------------------\n          ONLY TAX REFUNDABLE.\n          --------------------------------------------------\n          CHARGES ARE NON-COMMISISONABLE. APPLICABLE GST\n          WILL BE ADDITIONAL. 5 PERCENT GST FOR ALL ECONOMY\n          CLASS 12 PERCENT GST FOR ALL FIRST / BUSINESS\n          CLASS.\n          --------------------------------------------------\n          NO SHOW IS WHEN A PAX FAILS TO CHANGE/CANCEL\n          BOOKING ATLEAST 02 HOURS BEFORE DEPARTURE OF THE\n          FLIGHT BEING CHANGED/CANCELLED.\n          -------------------------------------------------\n          THE CHANGE/REISSUE/CANCEL/REFUND CHARGE IS NON -\n          REFUNDABLE.\n          --------------------------------------------------\n          LOOK-IN OPTION-\n          RESERVATIONS BOOKED MORE THAN 7 DAYS PRIOR TO\n          COMMENCEMENT OF TRAVEL MAY BE REFUND OR REISSUED\n          WITHIN 24 HOURS OF BOOKING OF TICKET WITHOUT\n          PENALTY.RESERVATIONS BOOKED WITHIN 7 DAYS OF\n          COMMENCEMENT OF TRAVEL ARE SUBJECT TO THE\n          APPLICABLE CANCELLATION PENALTY.\n          FOR EXAMPLE A PASSENGER BOOKED A TICKET ON DEL-\n          BOM SECTOR ON 12/02/20 AT 1000 AM AND HIS DATE\n          OFDEPARTURE IS 20/02/2020 FROM DEL. NOW\n          PASSENGERCAN AMEND THE TICKET TILL 13/02/2020 UP\n          TO 0959 AM. A PASSENGER BOOKED A TICKET ON DEL\n          BOM SECTOR 12/02/2020 AND HIS DATE OF TRVEL IS\n          WITHIN 7 DAYS 16/02/2020 FROM DEL THEN PENALTY\n          FEE WILL BE APPLICABLE AS PER THE RULES.\n          RESERVATIONS BOOKED WITHIN 7 DAYS OF COMMENCEMENT\n          OF TRAVEL ARE SUBJECT TO THE APPLICABLE\n          CHANGE/CANCELLATION PENALTY.\n          --------------------------------------------------\n          THE ABOVE MENTIONED FREE LOOK IN OPTION IS\n          AUTOMATED FOR CANCELLATIONS DEFINED UNDER CAT33 .\n          HOWEVER IT  CAN NOT BE PROCESSED FOR CHANGES\n          DEFINED UNDER  CAT 31  THROUGH AUTOMATED SYSTEM.\n          HENCE KINDLY PROCESS MANUALLY.\n         NOTE -\n          FOR WAIVER OF PENALTY ON ACCOUNT OF DEATH OF\n          PASSENGER OR IMMEDIATE FAMILY MEMBER PLS REFER\n          BELOW NOTE\n          -------------------------------------------------\n          IN CASE OF DEATH OF A PASSENGER OR IMMEDIATE\n          FAMILY MEMBER BEFORE COMMENCEMENT OF TRAVEL\n          PENALTY CHARGES STAND WAIVED OFF. THE ABOVE IS\n          APPLICABLE ONLY WHEN TICKET IS PURCHASED BEFORE\n          DEATH OF PASSENGER OR IMMEDIATE FAMILY MEMBER IS\n          OCCURRED.\n          -------------------------------------------------\n          IMMEDIATE FAMILY SHALL BE LIMITED TO SPOUSE\n          CHILDREN INCLUDING ADOPTED CHILDREN PARENTS\n          BROTHERS SISTERS GRAND-PARENTS GRANDCHILDREN FA\n          FATHER IN LAW MOTHER IN LAW SISTER IN LAW BROTHER\n          IN LAW SON IN LAW AND DAUGHTER IN LAW\n          -----------------------------------------------\n          PENALTY ON ABOVE ACCOUNT IS WAIVED FOR FIRST\n          TRANSACTION ONLY. SUBSEQUENT TRANSACTION IF ANY\n          WILL ATTRACT APPLICABLE PENALTY.\n          -------------------------------------------------\n          IN CASE OF DEATH OF PASSENGER OCCURRED AFTER\n          COMMENCEMENT OF TRAVEL ACCOMPANYING PASSENGER MAY\n          TERMINATE TRAVEL OR INTERRUPT TRAVEL UNTIL\n          COMPLETION OF FORMALITIES AND RELIGIOUS CUSTOMS\n          IF ANY BUT IN NO EVENT LATER THAN FORTY FIVE 45\n          DAYS AFTER TRAVEL IS INTERRUPTED. THE TICKET OF\n          RETURNING PASSENGERS WILL BE ENDORSED RETURN\n          ACCOUNT DEATH NAME  AND SUCH ENDORSEMENT SHALL BE\n          AUTHENTICATED BY VALIDATION OR OTHER DUTY MANAGER\n          OFFICIAL STAMP. REFUND MAY BE ARRANGED. RE-\n          ROUTING MAY BE PERMITTED APPLICABLE PENALTY IF\n          ANY MAY BE WAIVED. DIFFERENCE OF FARE NEEDS TO BE\n          COLLECTED.\n          ----------------------------------------------\n          FOR RETURN-ONWARD TICKER REFUND DEDUCT ONE WAY\n          FARE AND LEVIES FOR THE TRAVELLED SECTOR AND\n          BALANCE AMOUNT MAY BE REFUNDED.\n          -----------------------------------------------\n          REFUND IN CASE OF DEATH WILL BE CALCAULTED AFTER\n          DEDUCTING  ONE WAY FARE FOR THE TRAVELLED SECTOR\n          AND BALANCE AMOUNT MAY BE REFUNDED.\n          -----------------------------------------------\n          IN THE EVENT A PASSENGER IS DISCONTINUING TRAVEL\n          WITH THE GROUP IN ACCORDANCE WITH THE ABOVE- THIS\n          SHALL NOT AFFECT THE ENTITLEMENT TO TRAVEL AT THE\n          GROUP FARE OF THE REMAINING PASSENGERS IN THE\n          GROUP.\n          NO WAIVER WILL BE GRANTED IN ABSENCE OF DEATH\n          CERTIFICATE ISSUED BY COMPETENT AUTHORITIES.\n          I.E.THOSE DESIGNATED TO ISSUE DEATH CERTIFICATE\n          BY APPLICABLE LAWS OF THE COUNTRY IN WHICH THE\n          DEATH OCCURRED. WAIVER ISSUING STATION MUST\n          RETAIN THE COPY OF DEATH CERTIFICATE AND RELATION\n          PROOF OF BEING PART OF IMMEDIATE FAMILY MEMBER.</td></tr></table></body></html>",
                        "FareRuleName": "PENALTIES",
                        "Segment_Id": "0"
                    }
                ]
            },
            "transaction": []
        },
        "message": "Flight fare rule fetched successfully"
    }
}';//$response->json();

            
            $statusCode = 200; // $response->status();
            return response()->json(json_decode($result),$statusCode);
            // if($result['status'] === false)
            // {
            //     return response()->json($result,$statusCode);   
            // }
            // else{
            //     if($response->successful())
            //     {
                    // return response()->json([

                    //     'success' => true,
                    //     'data' => $result,
                    // ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
            
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
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/rePrice';

        try {
            // Make the POST request using Laravel HTTP Client
            // $response = Http::withHeaders($headers)->post($url, $payload);/            
            // $result=$response->json();
            // $statusCode = $response->status();

            $result = '{
                "success": true,
                "data": {
                    "status": true,
                    "status_code": "TXN",
                    "request_id": "NjcwNjM2NjVjY2JkZTIwMjQtMTAtMDkgMTM6MjM6MDk=",
                    "payloads": {
                        "errors": [],
                        "data": {
                            "rePrice": [
                                {
                                    "Flight": {
                                        "Airline_Code": "AI",
                                        "Block_Ticket_Allowed": true,
                                        "Cached": false,
                                        "Destination": "DEL",
                                        "Fares": [
                                            {
                                                "FareDetails": [
                                                    {
                                                        "AirportTax_Amount": 1501,
                                                        "AirportTaxes": [
                                                            {
                                                                "Tax_Amount": 837,
                                                                "Tax_Code": "IN",
                                                                "Tax_Desc": "IN"
                                                            },
                                                            {
                                                                "Tax_Amount": 268,
                                                                "Tax_Code": "K3",
                                                                "Tax_Desc": "K3"
                                                            },
                                                            {
                                                                "Tax_Amount": 236,
                                                                "Tax_Code": "P2",
                                                                "Tax_Desc": "P2"
                                                            },
                                                            {
                                                                "Tax_Amount": 160,
                                                                "Tax_Code": "YR",
                                                                "Tax_Desc": "YR"
                                                            }
                                                        ],
                                                        "Basic_Amount": 5184,
                                                        "CancellationCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 3,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 3,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "4200",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Currency_Code": "INR",
                                                        "FareClasses": [
                                                            {
                                                                "Class_Code": "V",
                                                                "Class_Desc": "V",
                                                                "FareBasis": "VU1YXSII",
                                                                "Privileges": null,
                                                                "Segment_Id": 0
                                                            }
                                                        ],
                                                        "Free_Baggage": {
                                                            "Check_In_Baggage": "15 KG",
                                                            "Hand_Baggage": "5 KG"
                                                        },
                                                        "GST": 0,
                                                        "Gross_Commission": 0,
                                                        "Net_Commission": 0,
                                                        "PAX_Type": 0,
                                                        "Promo_Discount": 0,
                                                        "RescheduleCharges": [
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 0,
                                                                "DurationTo": 3,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 0,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "100",
                                                                "ValueType": 1
                                                            },
                                                            {
                                                                "Applicablility": 1,
                                                                "DurationFrom": 3,
                                                                "DurationTo": 365,
                                                                "DurationTypeFrom": 0,
                                                                "DurationTypeTo": 1,
                                                                "OfflineServiceFee": 0,
                                                                "OnlineServiceFee": 0,
                                                                "PassengerType": 0,
                                                                "Remarks": "",
                                                                "Return_Flight": false,
                                                                "Value": "3150",
                                                                "ValueType": 0
                                                            }
                                                        ],
                                                        "Service_Fee_Amount": 0,
                                                        "TDS": 0,
                                                        "Total_Amount": 6789,
                                                        "Trade_Markup_Amount": 104,
                                                        "YQ_Amount": 0
                                                    }
                                                ],
                                                "FareType": 0,
                                                "Fare_Id": "V4853652766814382298",
                                                "Fare_Key": null,
                                                "Food_onboard": "F",
                                                "GSTMandatory": false,
                                                "LastFewSeats": null,
                                                "ProductClass": "V",
                                                "PromptMessage": null,
                                                "Refundable": true,
                                                "Seats_Available": "9",
                                                "Warning": ""
                                            }
                                        ],
                                        "Flight_Id": "5184186127799212463",
                                        "Flight_Key": "KEYyzzeKky+MrIFfx5DuP7pNUBypqACgfsks20YRzNeEyJvPRwpqT4Y3JF8aLm1d+aDJYWc3VeOPfC61Oqr31ZX1+bwNYwVAfDnDvNvX9mX4c6k5jM8lDw==",
                                        "Flight_Numbers": null,
                                        "GST_Entry_Allowed": true,
                                        "HasMoreClass": true,
                                        "InventoryType": 7,
                                        "IsLCC": false,
                                        "Origin": "DED",
                                        "Repriced": true,
                                        "Segments": [
                                            {
                                                "Aircraft_Type": "32N",
                                                "Airline_Code": "AI",
                                                "Airline_Name": "Air India",
                                                "Arrival_DateTime": "12/15/2024 16:25",
                                                "Departure_DateTime": "12/15/2024 15:20",
                                                "Destination": "DEL",
                                                "Destination_City": "DELHI",
                                                "Destination_Terminal": "3",
                                                "Duration": "01:05",
                                                "Flight_Number": "2618",
                                                "Leg_Index": 0,
                                                "OperatedBy": null,
                                                "Origin": "DED",
                                                "Origin_City": "DEHRADUN",
                                                "Origin_Terminal": "",
                                                "Return_Flight": false,
                                                "Segment_Id": 0,
                                                "Stop_Over": null
                                            }
                                        ],
                                        "TravelDate": "12/15/2024"
                                    },
                                    "Frequent_Flyer_Accepted": true,
                                    "Required_PAX_Details": [
                                        {
                                            "Age": false,
                                            "DOB": false,
                                            "DefenceExpiryDate": false,
                                            "DefenceIssueDate": false,
                                            "DefenceServiceId": false,
                                            "First_Name": true,
                                            "Gender": false,
                                            "IdProof_Number": false,
                                            "Last_Name": true,
                                            "Mandatory_SSRs": null,
                                            "Nationality": false,
                                            "PanCard_No": false,
                                            "Passport_Expiry": false,
                                            "Passport_Issuing_Country": false,
                                            "Passport_Number": false,
                                            "Pax_type": 0,
                                            "Student_Id": false,
                                            "Title": true
                                        },
                                        {
                                            "Age": true,
                                            "DOB": true,
                                            "DefenceExpiryDate": false,
                                            "DefenceIssueDate": false,
                                            "DefenceServiceId": false,
                                            "First_Name": true,
                                            "Gender": false,
                                            "IdProof_Number": false,
                                            "Last_Name": true,
                                            "Mandatory_SSRs": null,
                                            "Nationality": false,
                                            "PanCard_No": false,
                                            "Passport_Expiry": false,
                                            "Passport_Issuing_Country": false,
                                            "Passport_Number": false,
                                            "Pax_type": 1,
                                            "Student_Id": false,
                                            "Title": true
                                        },
                                        {
                                            "Age": false,
                                            "DOB": true,
                                            "DefenceExpiryDate": false,
                                            "DefenceIssueDate": false,
                                            "DefenceServiceId": false,
                                            "First_Name": true,
                                            "Gender": false,
                                            "IdProof_Number": false,
                                            "Last_Name": true,
                                            "Mandatory_SSRs": null,
                                            "Nationality": false,
                                            "PanCard_No": false,
                                            "Passport_Expiry": false,
                                            "Passport_Issuing_Country": false,
                                            "Passport_Number": false,
                                            "Pax_type": 2,
                                            "Student_Id": false,
                                            "Title": true
                                        }
                                    ]
                                }
                            ]
                        },
                        "transaction": []
                    },
                    "message": "Flight re price fetched successfully"
                }
            }';

            // if($result['status'] === false)
            // {
                return response()->json(json_decode($result));   
            // }
            // else{
            //     if($response->successful())
            //     {
            //         return response()->json([
            //             'success' => true,
            //             'data' => $result,
            //         ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
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
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/tempBooking';
        
        try {
            // Make POST request
            // $response = Http::withHeaders($headers)->post($url, $payload);
            // $result = $response->json();
            // $statusCode = $response->status();

            $response = '{
                "success": true,
                "data": {
                    "status": true,
                    "status_code": "TXN",
                    "request_id": "NjcwNjM2YzE0NjdkZTIwMjQtMTAtMDkgMTM6MjQ6NDE=",
                    "payloads": {
                        "errors": [],
                        "data": {
                            "bookingRef": "TBB7V78R"
                        },
                        "transaction": []
                    },
                    "message": "temporary booking successfully"
                }
            }';
            
            return response()->json(json_decode($response));

            // if ($result['status'] === false) {
            //     return response()->json($result, $statusCode);
            // } else {
            //     if ($response->successful()) {
            //         return response()->json([
            //             'success' => true,
            //             'data' => $result,
            //         ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
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
            "bookingRef" => "required|string", 
            "pnr" => "nullable|string"
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
            "bookingRef" => $data['bookingRef'], //"TBB7V78R",
            "pnr" => $data["pnr"]
        ];
        
        // Headers
        $headers = [
            'D-SECRET-TOKEN' => $data['headersToken'],
            'D-SECRET-KEY' => $data['headersKey'],
            'CROP-CODE' => 'DOTMIK160614',
            'Content-Type' => 'application/json',
        ];

        // API URL
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/rePrintTicket';

        try {
            // Make the POST request using Laravel HTTP Client
            // $response = Http::withHeaders($headers)->post($url, $payload);
            // $result=$response->json();
            // $statusCode = $response->status();

            // if($result['status'] === false)
            // {
            //     return response()->json($result,$statusCode);   
            // }
            // else{
            //     if($response->successful())
            //     {
            //         return response()->json([
            //             'success' => true,
            //             'data' => $result,
            //         ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
            //code...

            $response = '{
                "success": true,
                "data": {
                    "status": true,
                    "status_code": "TXN",
                    "request_id": "NjcwNjU3YjdiMTkwNTIwMjQtMTAtMDkgMTU6NDU6MTk=",
                    "payloads": {
                        "errors": [],
                        "data": {
                            "rePrintTicket": {
                                "adultCount": 1,
                                "pnrDetails": [
                                    {
                                        "Airline_Code": "AI",
                                        "Airline_Name": null,
                                        "Airline_PNR": "5JUN3J",
                                        "BlockedExpiryDate": "",
                                        "BookingChangeRequests": [],
                                        "CRS_Code": "",
                                        "CRS_PNR": "972DSY",
                                        "FailureRemark": null,
                                        "Flights": [
                                            {
                                                "Airline_Code": "AI",
                                                "Block_Ticket_Allowed": false,
                                                "Cached": false,
                                                "Destination": "DELHI (DEL)",
                                                "Fares": [
                                                    {
                                                        "FareDetails": [
                                                            {
                                                                "AirportTax_Amount": 1501,
                                                                "AirportTaxes": [
                                                                    {
                                                                        "Tax_Amount": 236,
                                                                        "Tax_Code": "P2",
                                                                        "Tax_Desc": "P2"
                                                                    },
                                                                    {
                                                                        "Tax_Amount": 268,
                                                                        "Tax_Code": "K3",
                                                                        "Tax_Desc": "K3"
                                                                    },
                                                                    {
                                                                        "Tax_Amount": 160,
                                                                        "Tax_Code": "YR",
                                                                        "Tax_Desc": "YR"
                                                                    },
                                                                    {
                                                                        "Tax_Amount": 837,
                                                                        "Tax_Code": "IN",
                                                                        "Tax_Desc": "IN"
                                                                    }
                                                                ],
                                                                "Basic_Amount": 5184,
                                                                "CancellationCharges": [
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 0,
                                                                        "DurationTo": 3,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 0,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "100",
                                                                        "ValueType": 1
                                                                    },
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 3,
                                                                        "DurationTo": 365,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 1,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "4200.00",
                                                                        "ValueType": 0
                                                                    }
                                                                ],
                                                                "Currency_Code": "INR",
                                                                "FareClasses": [
                                                                    {
                                                                        "Class_Code": "V",
                                                                        "Class_Desc": "V",
                                                                        "FareBasis": "VU1YXSII",
                                                                        "Privileges": null,
                                                                        "Segment_Id": 0
                                                                    }
                                                                ],
                                                                "Free_Baggage": {
                                                                    "Check_In_Baggage": "15 KG",
                                                                    "Hand_Baggage": "5 KG"
                                                                },
                                                                "GST": 0,
                                                                "Gross_Commission": 0,
                                                                "Net_Commission": 0,
                                                                "PAX_Type": 0,
                                                                "Promo_Discount": 0,
                                                                "RescheduleCharges": [
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 0,
                                                                        "DurationTo": 3,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 0,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "100",
                                                                        "ValueType": 1
                                                                    },
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 3,
                                                                        "DurationTo": 365,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 1,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "3150.00",
                                                                        "ValueType": 0
                                                                    }
                                                                ],
                                                                "Service_Fee_Amount": 0,
                                                                "TDS": 0,
                                                                "Total_Amount": 6789,
                                                                "Trade_Markup_Amount": 0,
                                                                "YQ_Amount": 0
                                                            }
                                                        ],
                                                        "FareType": 0,
                                                        "Fare_Id": null,
                                                        "Fare_Key": null,
                                                        "Food_onboard": "F",
                                                        "GSTMandatory": false,
                                                        "LastFewSeats": null,
                                                        "ProductClass": "V",
                                                        "PromptMessage": null,
                                                        "Refundable": true,
                                                        "Seats_Available": null,
                                                        "Warning": ""
                                                    }
                                                ],
                                                "Flight_Id": "5184186127799212463",
                                                "Flight_Key": "KEY3pIuMX9fQaqcBfq1wQGGjn9RLsgqCzknNCNiQw6vgyFoNdSgzhN41GpyivXqXpw9chox8PVnS/FQ0CDyo4oCzAOrnL0URI28i0dOCi6ZiaI5J1JZjGH+Hmt8yevN0KKcK06+MW1IGFKitXvw4dJPUILZ9EncgyymhhPzy/Qkv6z1AFyQPWjV1dnKSu6uRL/67COjMsgHgiZFkIKsy0PtC4eNvpxbSA30ZW4SFwzw2qCFAJGPM2Gh2ziYyV84by3Wx7Iv+nH1Qv/QL+92FfvI/u+Co67nc1xavmO9vL4e1MDQbiEgx4P8HToxCQXZ25EMndJ/vXh/EqUx6qZFYCbri2ZD5+dSwxiD6W/O4rYulQQfKf22957MLOMDDzsoSPW6Ck8euxD7OzS6odCCjSsX7y151oaVwd+uV0XzbtwawR+JNoOr/epTzvTUEKjSC7OnHpQnKUKQWQvy3jyUZ6nZIdMfhQDfNSkgx5YZPIxPjBc4sCxnGsx+VjH04nGeAbuXkYZNUPBi/f9CD/G2pNqSDkYAS7AVgCuVQ+NrQ3ysNsQn9EQ64den1ZSH2ZJ00SAZldO5NnnRc3qd4ik8PDqYbcrI0saZXYorfx1R6pBmzV6oiqqjxBvp7iBOZ60f1f3s",
                                                "Flight_Numbers": null,
                                                "GST_Entry_Allowed": false,
                                                "HasMoreClass": false,
                                                "InventoryType": 7,
                                                "IsLCC": false,
                                                "Origin": "DEHRADUN (DED) ",
                                                "Repriced": false,
                                                "Segments": [
                                                    {
                                                        "Aircraft_Type": "32N",
                                                        "Airline_Code": "AI",
                                                        "Airline_Name": "Air India",
                                                        "Arrival_DateTime": "12/15/2024 16:25:00",
                                                        "Departure_DateTime": "12/15/2024 15:20:00",
                                                        "Destination": "DELHI (DEL) ",
                                                        "Destination_City": null,
                                                        "Destination_Terminal": "3",
                                                        "Duration": "01:05",
                                                        "Flight_Number": "2618",
                                                        "Leg_Index": 0,
                                                        "OperatedBy": null,
                                                        "Origin": "DEHRADUN (DED) ",
                                                        "Origin_City": null,
                                                        "Origin_Terminal": "",
                                                        "Return_Flight": false,
                                                        "Segment_Id": 0,
                                                        "Stop_Over": null
                                                    }
                                                ],
                                                "TravelDate": "12/15/2024"
                                            }
                                        ],
                                        "Gross_Amount": 6789,
                                        "PAXTicketDetails": [
                                            {
                                                "Age": "0",
                                                "DOB": "09-09-1990",
                                                "Fares": [
                                                    {
                                                        "FareDetails": [
                                                            {
                                                                "AirportTax_Amount": 1501,
                                                                "AirportTaxes": [
                                                                    {
                                                                        "Tax_Amount": 236,
                                                                        "Tax_Code": "P2",
                                                                        "Tax_Desc": "P2"
                                                                    },
                                                                    {
                                                                        "Tax_Amount": 268,
                                                                        "Tax_Code": "K3",
                                                                        "Tax_Desc": "K3"
                                                                    },
                                                                    {
                                                                        "Tax_Amount": 160,
                                                                        "Tax_Code": "YR",
                                                                        "Tax_Desc": "YR"
                                                                    },
                                                                    {
                                                                        "Tax_Amount": 837,
                                                                        "Tax_Code": "IN",
                                                                        "Tax_Desc": "IN"
                                                                    }
                                                                ],
                                                                "Basic_Amount": 5184,
                                                                "CancellationCharges": [
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 0,
                                                                        "DurationTo": 3,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 0,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "100",
                                                                        "ValueType": 1
                                                                    },
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 3,
                                                                        "DurationTo": 365,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 1,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "4200.00",
                                                                        "ValueType": 0
                                                                    }
                                                                ],
                                                                "Currency_Code": "INR",
                                                                "FareClasses": [
                                                                    {
                                                                        "Class_Code": "V",
                                                                        "Class_Desc": "V",
                                                                        "FareBasis": "VU1YXSII",
                                                                        "Privileges": null,
                                                                        "Segment_Id": 0
                                                                    }
                                                                ],
                                                                "Free_Baggage": {
                                                                    "Check_In_Baggage": "15 KG",
                                                                    "Hand_Baggage": "5 KG"
                                                                },
                                                                "GST": 0,
                                                                "Gross_Commission": 0,
                                                                "Net_Commission": 0,
                                                                "PAX_Type": 0,
                                                                "Promo_Discount": 0,
                                                                "RescheduleCharges": [
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 0,
                                                                        "DurationTo": 3,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 0,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "100",
                                                                        "ValueType": 1
                                                                    },
                                                                    {
                                                                        "Applicablility": 1,
                                                                        "DurationFrom": 3,
                                                                        "DurationTo": 365,
                                                                        "DurationTypeFrom": 0,
                                                                        "DurationTypeTo": 1,
                                                                        "OfflineServiceFee": 0,
                                                                        "OnlineServiceFee": 0,
                                                                        "PassengerType": 0,
                                                                        "Remarks": "",
                                                                        "Return_Flight": false,
                                                                        "Value": "3150.00",
                                                                        "ValueType": 0
                                                                    }
                                                                ],
                                                                "Service_Fee_Amount": 0,
                                                                "TDS": 0,
                                                                "Total_Amount": 6789,
                                                                "Trade_Markup_Amount": 0,
                                                                "YQ_Amount": 0
                                                            }
                                                        ],
                                                        "FareType": 0,
                                                        "Fare_Id": null,
                                                        "Fare_Key": null,
                                                        "Food_onboard": "F",
                                                        "GSTMandatory": false,
                                                        "LastFewSeats": null,
                                                        "ProductClass": "V",
                                                        "PromptMessage": null,
                                                        "Refundable": true,
                                                        "Seats_Available": null,
                                                        "Warning": ""
                                                    }
                                                ],
                                                "First_Name": "MMR",
                                                "FrequentFlyerDetails": null,
                                                "Gender": 0,
                                                "Last_Name": "Solutions",
                                                "Nationality": "Indian",
                                                "Passport_Expiry": "09-09-2030",
                                                "Passport_Issuing_Country": "India",
                                                "Passport_Number": "1234567891",
                                                "Pax_Id": 1,
                                                "Pax_type": 0,
                                                "SSRDetails": [],
                                                "TicketDetails": [
                                                    {
                                                        "Flight_Id": "5184186127799212463",
                                                        "SegemtWiseChanges": [
                                                            {
                                                                "CancelRequestId": "0",
                                                                "CancelStatus": "LIVE",
                                                                "Destination": "DEL",
                                                                "Origin": "DED",
                                                                "RescheduleRequestId": "0",
                                                                "RescheduleStatus": "LIVE",
                                                                "Return_Flight": false,
                                                                "Segement_Id": "0"
                                                            }
                                                        ],
                                                        "SupPax_ID": null,
                                                        "Ticket_Number": "0983420649446"
                                                    }
                                                ],
                                                "TicketStatus": "Live",
                                                "Title": "Mr"
                                            }
                                        ],
                                        "Post_Markup": 0,
                                        "Record_Locator": "",
                                        "RetailerPostMarkup": 0,
                                        "Supplier_RefNo": "1MK563",
                                        "Ticket_Status_Desc": "Confirmed",
                                        "Ticket_Status_Id": "4",
                                        "TicketingDate": "10/09/2024 13:26:30"
                                    }
                                ],
                                "Booking_DateTime": "09/10/2024 13:24:42",
                                "Booking_RefNo": "TBB7V78R",
                                "Booking_Type": 0,
                                "Child_Count": 0,
                                "Class_of_Travel": 0,
                                "GST": false,
                                "GSTIN": "",
                                "Infant_Count": 0,
                                "Invoice_Number": "DN/OCT-24/0807091",
                                "PAX_EmailId": "adhikari@gmail.com",
                                "PAX_Mobile": "9910179393",
                                "Remark": "Test booking with PAX details",
                                "Travel_Type": 0
                            }
                        },
                        "transaction": []
                    },
                    "message": "Ticket details fetched successfully"
                }
            }';

            return response()->json(json_decode($response));
            
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
                'success' => 0,
                'error' => $formattedErrors[0]
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
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/cancellation';

        try {
            // Make the POST request using Laravel HTTP Client
            // $response = Http::withHeaders($headers)->post($url, $payload);
            // $result=$response->json();
            // $statusCode = $response->status();

            // if($result['status'] === false)
            // {
            //     return response()->json($result,$statusCode);   
            // }
            // else{
            //     if($response->successful())
            //     {
            //         return response()->json([
            //             'success' => true,
            //             'data' => $result,
            //         ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
            $response = '{
                "success": true,
                "data": {
                    "status": true,
                    "status_code": "TXN",
                    "request_id": "NjcwNjU5MmIzMDU0NTIwMjQtMTAtMDkgMTU6NTE6MzE=",
                    "payloads": {
                        "errors": [],
                        "data": [],
                        "transaction": []
                    },
                    "message": "Ticket Has been cancelled refund will process shortly"
                }
            }';
            
            return response()->json(json_decode($response));

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
        // $url = 'https://api.dotmik.in/api/flightBooking/v1/lowFare';

        try {
            // Make the POST request using Laravel HTTP Client
            // $response = Http::withHeaders($headers)->post($url, $payload);
            // $result=$response->json();
            // $statusCode = $response->status();
            $result='{
                "success": true,
                "data": {
                    "status": true,
                    "status_code": "TXN",
                    "request_id": "NjcwNjVkYTE0OGU5YzIwMjQtMTAtMDkgMTY6MTA6MzM=",
                    "payloads": {
                        "errors": [],
                        "data": {
                            "lowFareData": [
                                {
                                    "AirlineCode": "JL",
                                    "Amount": 46672,
                                    "TravelDate": "10/23/2024"
                                }
                            ]
                        },
                        "transaction": []
                    },
                    "message": "Low Fare data fetched successfully"
                }
            }';
            return response()->json(json_decode($result));
            // if($result['status'] === false)
            // {
            //     return response()->json($result,$statusCode);   
            // }
            // else{
            //     if($response->successful())
            //     {
                    return response()->json([
                        'success' => true,
                        'data' => $result,
                    ], 200);
            //     } else {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to fetch flight data',
            //             'error' => $response->json()
            //         ], $response->status());
            //     }
            // }
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
