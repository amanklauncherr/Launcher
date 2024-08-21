<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderIDCreation;
use Illuminate\Support\Str;

class OrderIDCreationController extends Controller
{
    //
    public function AddOrderID(Request $request)
    {
        $request->validate([
            'OrderDetails' => 'required|array',
        ]);

        try {
            //code...
            $timestamp = time(); // Current timestamp
            $orderID = 'launcherr' . Str::upper(substr(md5($timestamp), 0, 12)); // Generate 12 characters from MD5 hash
    
            $order = OrderIDCreation::create([
                'OrderDetails' => json_encode($request->OrderDetails),
                'OrderID' => $orderID,
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
}
