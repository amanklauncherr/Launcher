<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AdminCancelOrderMail;
use App\Mail\AdminOrderMail;
use App\Mail\OrderDetailMail;
use App\Mail\UserCancelOrderMail;
use Illuminate\Http\Request;
use App\Models\OrderIDCreation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderIDCreationController extends Controller
{
    //

    /**
     * @group Order
     * 
     * Add a new order.
     *
     * This endpoint is used to create a new order.
     * 
     * **Note:** This endpoint requires an `Authorization: Bearer <access_token>` header.
     * 
     * **Note:** You will get the access_token after User Login
     * 
     * @authenticated
     * 
     * @header Authorization Bearer {access_token}
     * 
     * @bodyParam OrderDetails array required The details of the order.
     * @response 201 {
     *   "success": 1,
     *   "order": {
     *     "id": 1,
     *     "user_id": 1,
     *     "OrderDetails": "{\"item\":\"product\"}",
     *     "OrderID": "launcherr123ABC",
     *     "Status": "Order Created",
     *     "created_at": "2024-10-29T00:00:00.000000Z",
     *     "updated_at": "2024-10-29T00:00:00.000000Z"
     *   }
     * }
     * @response 422 {
     *   "success": 0,
     *   "error": "The OrderDetails field is required."
     * }
     * 
     * @response 500 {
     *   "success": 0,
     *   "message" : 'Order Creation Failure', 
     *   "error" : 'Internal Serve Error'
     * }
     * 
     */

    public function AddOrderID(Request $request)
    {
        $validator=Validator::make($request->all(),[
        'OrderDetails' => 'required|array',     
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first(); // Get all error messages
            return response()->json([
                'success' => 0,
                'error' => $error
            ], 422);
        }

        try {
            //code...
            $timestamp = time(); // Current timestamp
            $orderID = 'launcherr' . Str::upper(substr(md5($timestamp), 0, 12)); // Generate 12 characters from MD5 hash
    
            $order = OrderIDCreation::create([
                'user_id' => Auth()->guard()->id(),
                'OrderDetails' => json_encode($request->OrderDetails),
                'OrderID' => $orderID,
                'Status' => 'PaymentPending'
            ]);
            return response()->json(['success' => 1, 'order' => $order], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0, 
                'message' => 'Order Creation Failure', 
                'error' => $e->getMessage()], 
                500);
        }
    }


    /**
     * 
     * @group Order 
     * 
     * Update Order status.
     *
     * This endpoint allows updating the status of an existing order.
     * 
     * **Note:** This endpoint requires an `Authorization: Bearer <access_token>` header.
     *
     * **Note:** You will get the access_token after User Login
     * 
     * @authenticated
     * 
     * @header Authorization Bearer {access_token}
     * 
     * @bodyParam OrderID string required The unique identifier for the order. Example: launcherr123ABC
     * @bodyParam OrderStatus string required The new status of the order. Example: Delivered
     * @response 200 {
     *   "success": 1,
     *   "message": "Status Updated"
     * }
     * @response 400 {
     *   "success": 0,
     *   "message": "No Order Found"
     * }
     * 
     * @response 500 {
     *   "success": 0,
     *   "message" : 'An error occurred Update Order Status', 
     *   "error" : 'Internal Serve Error'
     * 
     */

    public function UpdateOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'OrderID' => 'required|string',
            'OrderStatus' => 'required|string|in:PaymentSuccess',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => 0,
                'error' => $error
            ], 422);
        }

        try {
            $data = $validator->validated();

            // Fetch the order
            $order_id = $data['OrderID'];
            $order = OrderIDCreation::where('OrderID', $data['OrderID'])->first();
            if (!$order) {
                return response()->json([
                    'success' => 0,
                    'message' => 'No Order Found',
                ], 400);
            }

            // Update the order status
            $user = Auth()->guard('api')->user();
            $OrderDetails = json_decode($order->OrderDetails, true);


            // Send email for successful payment
            if ($data['OrderStatus'] === 'PaymentSuccess') {

                Mail::to($user->email)->send(new OrderDetailMail($OrderDetails,$order_id));

                $AdminText="New Order Received. Order ID -: {$data['OrderID']}";

                // Mail::to('info@launcherr.co')->send(new AdminOrderMail($AdminText));
                Mail::to('info@launcherr.co')->send(new AdminOrderMail($AdminText));
                Mail::to('productsupport@launcherr.co')->send(new AdminOrderMail($AdminText));

                // Create WooCommerce order via cURL
                $consumer_key =  'ck_8898974d9ec697fc5f72ff4e818d42e74a1b82cd'; //'ck_your_consumer_key';
                $consumer_secret = 'cs_b071355158fc13fba60d739ed9bb813e3b4f342d'; //'cs_your_consumer_secret';
                $store_url = 'https://ecom2.launcherr.co';

                // WooCommerce API endpoint
                $url = $store_url . '/wp-json/wc/v3/orders';

                // Prepare WooCommerce payload
                $wooCommercePayload = [
                    "payment_method" => "Online",
                    "payment_method_title" => "Payment Online",
                    "set_paid" => true,
                    "billing" =>[
                        "first_name" => $OrderDetails['billing']['firstName'],
                        "last_name" => $OrderDetails['billing']['lastName'],
                        "address_1" => $OrderDetails['billing']['address1'] ,
                        "address_2" => $OrderDetails['billing']['address2'] ?? " ",
                        "city" => $OrderDetails['billing']['city'] ,
                        "state" => $OrderDetails['billing']['state'] ,
                        "postcode" => $OrderDetails['billing']['postcode'] ,
                        "country" => 'India',
                        "email" =>  $OrderDetails['billing']['email'],
                        "phone" => (string) $OrderDetails['billing']['phone'] 
                    ],  
 
                    // $OrderDetails['billing'],
 
                    "shipping" => [
                        "first_name" => $OrderDetails['shipping']['firstName'] ?? $OrderDetails['billing']['firstName'],
                        "last_name" => $OrderDetails['shipping']['last_name'] ?? $OrderDetails['billing']['lastName'],
                        "address_1" => $OrderDetails['shipping']['address1'] ?? $OrderDetails['billing']['address1'],
                        "address_2" => $OrderDetails['shipping']['address2'] ?? " ",
                        "city" => $OrderDetails['shipping']['city'] ?? $OrderDetails['billing']['city'],
                        "state" => $OrderDetails['shipping']['state'] ??$OrderDetails['billing']['state'] ,
                        "postcode" => $OrderDetails['shipping']['postcode'] ??$OrderDetails['billing']['postcode'] ,
                        "country" => 'India',
                        // "email" =>  $OrderDetails['shipping']['email'],
                        "phone" => (string) $OrderDetails['shipping']['phone'] ?? (string) $OrderDetails['billing']['phone']
                    ] ,
                    "line_items" => array_map(function ($product) {
                        return [
                            "product_id" => $product['product_id'],
                            "quantity" => $product['quantity']
                        ];
                    }, $OrderDetails['products'] ?? []),
                    "shipping_lines" => [
                        [
                            "method_id" => "flat_rate",
                            "method_title" => "Shipping Charge",
                            // "total" => $OrderDetails['shippingCharge'] ?? 0
                            "total" => strval($OrderDetails['shippingCharge'] ?? "0")

                        ]
                    ]
                ];

                // Define headers for the request
                $headers = [
                    'Authorization' => 'Basic ' . base64_encode("$consumer_key:$consumer_secret"),
                    'Content-Type' => 'application/json',
                ];

                // Send the WooCommerce API request using Laravel's Http client
                $response = Http::withHeaders($headers)->timeout(60)->post($url, $wooCommercePayload);

                // Check for API response errors
                if ($response->failed()) {
                    return response()->json([
                        'success' => 0,
                        'message' => 'WooCommerce API error: ' . $response->body(),
                    ], 500);
                }
                // Get the response in JSON format
                $result = $response->json();

                $order->update(
                    [
                        'Status' => $data['OrderStatus'],
                        'WooCommerceID' => $result['id'],
                    ]
                );
        }
            return response()->json([
                'success' => 1,
                'message' => 'Status Updated and WooCommerce order created successfully',
                'result' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => 'An error occurred while updating order status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



  public function CancelOrder(Request $request)
  {

    $orderID = $request->input('OrderID'); 

    if(!$orderID)
    {
        return response()->json([
            'success' => 0,
            'message' => 'Please Provide Order ID',
        ], 400);
    }

    try {
        // Fetch the order
        $order = OrderIDCreation::where('OrderID', $orderID)->first();
        $user = Auth()->guard('api')->user();

        if (!$order) {
            return response()->json([
                'success' => 0,
                'message' => 'No Order Found',
            ], 400);
        }

        // Update the order status
        // $user = Auth()->guard('api')->user();

        // WooCommerce REST API credentials
            // Create WooCommerce order via cURL
            $consumer_key =  'ck_8898974d9ec697fc5f72ff4e818d42e74a1b82cd'; //'ck_your_consumer_key';
            $consumer_secret = 'cs_b071355158fc13fba60d739ed9bb813e3b4f342d'; //'cs_your_consumer_secret';
            $store_url = 'https://ecom2.launcherr.co';

            // WooCommerce API endpoint
            $url = $store_url . '/wp-json/wc/v3/orders';

            $order_id = $order['WooCommerceID']; // Replace with your order ID

            // API Endpoint
            $url = $store_url . "/wp-json/wc/v3/orders/$order_id";

            // Data for cancelling the order
            $data = [
                'status' => 'cancelled',
            ];
            // $data = [
            //     'status' => 'refund-request',
            // ];

            // Define headers for the request
            $headers = [
                'Authorization' => 'Basic ' . base64_encode("$consumer_key:$consumer_secret"),
                'Content-Type' => 'application/json',
            ];

            // Send the WooCommerce API request using Laravel's Http client
            $response = Http::withHeaders($headers)->timeout(60)->post($url, $data);


                // Check for API response errors
                if ($response->failed()) {
                    return response()->json([
                        'success' => 0,
                        'message' => 'WooCommerce API error: ' . $response->body(),
                    ], 500);
                }
                // Get the response in JSON format
                $result = $response->json();

                $order->update(
                    [
                        'Status' => 'OrderCancelled',
                    ]
                );

                $OrderCancel = "Order Cancelled. Order ID -: {$orderID}";

                $OrderDetails = json_decode($order->OrderDetails, true);
                $order_date = $order->created_at;

                Mail::to($user->email)->send(new UserCancelOrderMail($OrderDetails,$orderID,$order_date));

                Mail::to('info@launcherr.co')->send(new AdminCancelOrderMail($OrderCancel));
                
                return response()->json([
                    'success' => 1,
                    'message' => 'Order Cancelled Successfully',
                    'result' => $result
                ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => 'An error occurred while updating order status',
                'error' => $e->getMessage(),
                'errorLine' => $e->getLine()
            ], 500);
        }

  }



  public function ReturnOrder(Request $request)
  {

    $orderID = $request->input('OrderID'); 

    if(!$orderID)
    {
        return response()->json([
            'success' => 0,
            'message' => 'Please Provide Order ID',
        ], 400);
    }

    try {
        // Fetch the order
        $order = OrderIDCreation::where('OrderID', $orderID)->first();
        $user = Auth()->guard('api')->user();

        if (!$order) {
            return response()->json([
                'success' => 0,
                'message' => 'No Order Found',
            ], 400);
        }

        // Update the order status
        // $user = Auth()->guard('api')->user();

        // WooCommerce REST API credentials
            // Create WooCommerce order via cURL
            $consumer_key =  'ck_8898974d9ec697fc5f72ff4e818d42e74a1b82cd'; //'ck_your_consumer_key';
            $consumer_secret = 'cs_b071355158fc13fba60d739ed9bb813e3b4f342d'; //'cs_your_consumer_secret';
            $store_url = 'https://ecom2.launcherr.co';

            // WooCommerce API endpoint
            $url = $store_url . '/wp-json/wc/v3/orders';

            $order_id = $order['WooCommerceID']; // Replace with your order ID

            // API Endpoint
            $url = $store_url . "/wp-json/wc/v3/orders/$order_id";

            // Data for cancelling the order
            // $data = [
            //     'status' => 'cancelled',
            // ];
            $data = [
                'status' => 'refund-request',
            ];

            // Define headers for the request
            $headers = [
                'Authorization' => 'Basic ' . base64_encode("$consumer_key:$consumer_secret"),
                'Content-Type' => 'application/json',
            ];

            // Send the WooCommerce API request using Laravel's Http client
            $response = Http::withHeaders($headers)->timeout(60)->post($url, $data);


                // Check for API response errors
                if ($response->failed()) {
                    return response()->json([
                        'success' => 0,
                        'message' => 'WooCommerce API error: ' . $response->body(),
                    ], 500);
                }
                // Get the response in JSON format
                $result = $response->json();

                $order->update(
                    [
                        'Status' => 'OrderRefund',
                    ]
                );

                $OrderCancel = "Requesting for Return/Refund. Order ID -: {$orderID}";

                // try {
                //     Mail::to($user->email)->send(new UserCancelOrderMail($OrderCancel));
                // } catch (\Exception $e) {
                //     \Log::error('Failed to send cancellation email to user: ' . $e->getMessage());
                // }
                // try {
                //     Mail::to(env('ADMINMAIL'))->send(new AdminCancelOrderMail($OrderCancel));
                // } catch (\Exception $e) {
                //     \Log::error('Failed to send cancellation email to admin: ' . $e->getMessage());
                // }

                Mail::to($user->email)->send(new AdminCancelOrderMail($OrderCancel));

                // Mail::to('info@launcherr.co')->send(new AdminCancelOrderMail($OrderCancel));
                Mail::to('info@launcherr.co')->send(new AdminCancelOrderMail($OrderCancel));
                
                return response()->json([
                    'success' => 1,
                    'message' => 'Return/Refund Application Submited Successfully',
                    'result' => $result
                ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => 'An error occurred while updating order status',
                'error' => $e->getMessage(),
                'errorLine' => $e->getLine()
            ], 500);
        }

  }


    /**
     * @group Order
     * 
     * Get orders of the logged-in user.
     *
     * This endpoint retrieves all orders placed by the authenticated user.
     * 
     * **Note:** This endpoint requires an `Authorization: Bearer <access_token>` header.
     *
     * **Note:** You will get the access_token after User Login
     * 
     * @authenticated
     * 
     * @header Authorization Bearer {access_token}
     *
     * @response 200 {
     *   "success": 1,
     *   "message": "Order List for John Doe",
     *   "data": [
     *     {
     *       "id": 1,
     *       "OrderID": "launcherr123ABC",
     *       "OrderDetails": {
     *         "item": "product"
     *       },
     *       "OrderStatus": "Order Created"
     *     }
     *   ]
     * }
     * @response 400 {
     *   "success": 0,
     *   "message": "No Order Found for John Doe"
     * }
     */


    public function GetOrderUser(Request $request)
    {
        $tokenType = $request->attributes->get('token_type');

        if ($tokenType === 'public') {
            return response()->json(
                [
                    'success'=> 0,
                    'message' => 'Unauthorized, Login To Add Enquiry'
                ]
            );
        }
        else if ($tokenType === 'user') {
            $user = $request->attributes->get('user');

            $order= OrderIDCreation::where('user_id',$user->id)->get();
    
            if($order->isEmpty())
            {
                return response()->json(['success'=>0, 'message' => "No Order Found for {$user->name}"],400);
            }
            $data=[];
            foreach($order as $Order)
            {
                $final = [
                    'id'=>$Order->id,
                    'OrderID' => $Order->OrderID,
                    'OrderDetails' => json_decode($Order->OrderDetails,true),
                    'OrderStatus' => $Order->Status,
                    'created_at' => $Order->created_at,
                    'updated_at' => $Order->updated_at
                ];
                array_push($data,$final);
            }
            return response()->json(
                [
                    'success'=>1, 
                    'message' => "{$user->name} Order List", 
                    'data' => $data
                ],200);    
        }


    }

    /**
     * Get details of an order.
     *
     * This endpoint retrieves the details of a specific order using its OrderID.
     *
     * @bodyParam OrderID string required The unique identifier for the order. Example: launcherr123ABC
     * @response 200 {
     *   "success": 1,
     *   "message": "Order Detail",
     *   "data": {
     *     "OrderStatus": "Order Created",
     *     "OrderDetails": {
     *       "item": "product"
     *     }
     *   }
     * }
     * @response 400 {
     *   "success": 0,
     *   "message": "No Order Detail Found"
     * }
     */

    public function GetOrderDetails(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'OrderID' => 'required|string',
            ]);
    
        if ($validator->fails()) {
            $error = $validator->errors()->first(); // Get all error messages
            return response()->json([
                'success' => 0,
                'error' => $error
            ], 422);
        }
        try {
            //code...

            $data=$validator->validated();

            $order=OrderIDCreation::where('OrderID',$data['OrderID'])->first();

            if(!$order)
            {
                return response()->json(['success' => 0,'message' => 'No Order Detail Found'],400);
            }
            return response()->json(
                [
                    'success' => 1,
                    'message' => 'Order Detail',
                    'data' => [
                        "OrderStatus" => $order->status,
                        "OrderDetails"=>json_decode($order->OrderDetails,true)
                    ]
                 ],200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0, 
                'message' => 'Order Failure while Retreating', 
                'error' => $e->getMessage()], 
                500);
        }

    }



    /**
     * Get all orders.
     *
     * This endpoint retrieves a list of all orders in the system.
     *
     * @response 200 {
     *   "success": 1,
     *   "message": "Order List",
     *   "data": [
     *     {
     *       "id": 1,
     *       "OrderID": "launcherr123ABC",
     *       "OrderStatus": "Order Created",
     *       "OrderDetails": {
     *         "item": "product"
     *       }
     *     }
     *   ]
     * }
     * @response 400 {
     *   "success": 0,
     *   "message": "No Order Found"
     * }
     */
    public function GetAllOrders(Request $request)
    {
        $order= OrderIDCreation::get();

        if($order->isEmpty())
        {
            return response()->json(['success'=>0, 'message' => 'No Order Found'],400);
        }
        $data=[];
        foreach($order as $Order)
        {
            $final = [
                'id'=>$Order->id,
                'OrderID' => $Order->OrderID,
                'OrderStatus' => $Order->Status,
                'OrderDetails' => json_decode($Order->OrderDetails,true),
            ];
            array_push($data,$final);
        }
        return response()->json(
            [
                'success'=>1, 
                'message' => 'Order List', 
                'data' => $data
            ],200);
    }

    public function shippingChareges(Request $request){

        $pincode = $request->input('pincode');
        
        $payload = json_encode([
            "data" => [
                "pincode" => $pincode,
                "access_token" => "928d2cac511e5c5f138d883907a47516",
                "secret_key" => "39db01eb2f7915b4b7ecca28065403ce"
            ]
        ]);
// dd($payload);
        $curl = curl_init();
          curl_setopt_array($curl, array(
              CURLOPT_URL             => "https://my.ithinklogistics.com/api_v3/pincode/check.json",
              CURLOPT_RETURNTRANSFER  => true,
              CURLOPT_ENCODING        => "",
              CURLOPT_MAXREDIRS       => 10,
              CURLOPT_TIMEOUT         => 30,
              CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST   => "POST",
              CURLOPT_POSTFIELDS      => $payload,
              CURLOPT_HTTPHEADER      => array(
                  "cache-control: no-cache",
                  "content-type: application/json"
              )
          ));
      
          $response = curl_exec($curl);
          $err      = curl_error($curl);
          curl_close($curl);
          if ($err) 
          {
              echo "cURL Error #:" . $err;
          }
          else
          {
              return json_decode( $response);
          }
    }

public function checkRate(Request $request)
 {
    $pincode = $request->input('pincode');
    $shipping_weight_kg = $request->input('shipping_weight_kg');
    $product_mrp = $request->input('product_mrp');

    $response = Http::withHeaders([
        'cache-control' => 'no-cache',
        'content-type'  => 'application/json',
    ])->post('https://my.ithinklogistics.com/api_v3/rate/check.json', [
        'data' => [
            'from_pincode'         => '201301 ',
            "to_pincode"           => $pincode,
            'shipping_length_cms'  => '',
            'shipping_width_cms'   => '',
            'shipping_height_cms'  => '',
            'shipping_weight_kg'   => $shipping_weight_kg,
            'order_type'           => 'forward',
            'payment_method'       => 'Prepaid',
            'product_mrp'          => $product_mrp,
            'access_token'         => '928d2cac511e5c5f138d883907a47516',
            'secret_key'           => '39db01eb2f7915b4b7ecca28065403ce',
        ]
    ]);

    return response()->json($response->json());
 }

 public function addProductReview(Request $request)
 {
    $validator = Validator::make($request->all(), [
        'product_id' => 'required|integer',
        'review' => 'required|string',
        'rating' => 'required|integer|between:1,5',
        'reviewer' => 'required|string',
        'reviewer_email' => 'required|email',
    ]);

    if ($validator->fails()) {
        $error = $validator->errors()->first();
        return response()->json([
            'success' => 0,
            'error' => $error
        ], 422);
    }

    $data=$validator->validated();

    $consumer_key =  'ck_8898974d9ec697fc5f72ff4e818d42e74a1b82cd'; //'ck_your_consumer_key';
    $consumer_secret = 'cs_b071355158fc13fba60d739ed9bb813e3b4f342d'; //'cs_your_consumer_secret';

     $response = Http::withBasicAuth($consumer_key, $consumer_secret)
                     ->post("https://ecom2.launcherr.co/wp-json/wc/v3/products/reviews", [
                         'product_id' => $data['product_id'],
                         'review' => $data['review'],
                         'rating' => $data['rating'],
                         'reviewer' => $data['reviewer'],
                         'reviewer_email' => $data['reviewer_email'],
                     ]);
 
     return response()->json($response->json(), $response->status());
 }

 public function getProductReviews($product_id)
{
    $consumer_key =  'ck_8898974d9ec697fc5f72ff4e818d42e74a1b82cd'; //'ck_your_consumer_key';
    $consumer_secret = 'cs_b071355158fc13fba60d739ed9bb813e3b4f342d'; //'cs_your_consumer_secret';

    $response = Http::withBasicAuth($consumer_key, $consumer_secret)
                    ->get("https://ecom2.launcherr.co/wp-json/wc/v3/products/reviews?product=$product_id");

    return response()->json($response->json(), $response->status());
}

public function getshippingpdates(Request $request){

   
    //    $data =[{
    //     "awb_number" : "AWB001",
    //     "latest_scan_time" : "2022-04-04 15:20:25",
    //     "current_tracking_status" : "2",
    //     "status" : "picked up",
    //     "remark" : "picked",
    //     "location" : "mumbai",
    //     "edd_date" : "2022-04-10 15:20:25",
    //     "status_code" : "UD",
    //     "customer_name" : "XYZ",
    //     "customer_number" : "+91 XXXXX99999",
    //     "order_id" : "AB000",
    //     "order_type" : "forward",
    //     "logistics_name" : "ABCD",
    //     "shipment_type" : "FWD",
    //     "tracking_url" : "www.abc.xyz"
    //     }];
 }
 

}


