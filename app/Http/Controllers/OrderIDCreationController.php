<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderIDCreation;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderIDCreationController extends Controller
{
    //
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
                'Status' => 'OrderCreated'
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

    public function UpdateOrderStatus(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'OrderID' => 'required|string',
            'OrderStatus' => 'required|string',     
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
            $order = OrderIDCreation::where('OrderID',$data['OrderID'])->first();

            if(!$order)
            {
                return response()->json([
                    'success' => 0,
                    'message' => 'No Order Found',
                ], 400);
            }
            $order->update([
                'OrderStatus' => $data['OrderStatus']
            ]);
       
            return response()->json([
                'success' => 1,
                'message' => 'Status Updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => 'An error occurred while Adding Email',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

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
                ];
                array_push($data,$final);
            }
            return response()->json(
                [
                    'success'=>1, 
                    'message' => "Order List for {$user->name}", 
                    'data' => $data
                ],200);    
        }


    }

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
                'message' => 'Order Creation Failure', 
                'error' => $e->getMessage()], 
                500);
        }

    }


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
            // $data=[
            //     $final
            // ];
        }
        return response()->json(
            [
                'success'=>1, 
                'message' => 'Order List', 
                'data' => $data
            ],200);
    }

}
