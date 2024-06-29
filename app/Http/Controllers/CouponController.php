<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class CouponController extends Controller
{
    //
    public function addCoupon(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'coupon_code' => 'required|string|unique:coupons,coupon_code',
            'coupon_places' => 'required|array',
            'discount' => 'required|numeric|min:0|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            //code...
            
        $coupon=Coupon::create([
            'coupon_code'=>$request->coupon_code,
            'coupon_places'=>json_encode($request->coupon_places),
            'discount'=>$request->discount,
        ]);

        return response()->json(['message' => 'Coupon created successfully', 'coupon' => $coupon], 201);

        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while Adding Coupon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showCoupon(){
        $coupon=Coupon::all();
        // json_decode($coupon->coupon_places);
        if($coupon->isEmpty())
        {
            return response()->json(['Message'=>'No Coupon Found'],404);
        }
        else{
            return response()->json(['Coupon'=>$coupon],200);
        }
    }

    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|exists:coupons,coupon_code',
            'place' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            //code...
            $coupon = Coupon::where('coupon_code',$request->coupon_code)->first();

            if(!in_array($request->place,json_decode($coupon->coupon_places))){
                return response()->json(['error' => 'Coupon not applicable for this place'], 400);
            }
    
            return response()->json(['message' => 'Coupon applied successfully', 'discount' => $coupon->discount], 200);
        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Coupon not found'], 404);
        }catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while Adding Coupon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateCoupon(Request $request,$coupon_code)
    {
        $validator = Validator::make($request->all(),[
            'coupon_places' => 'sometimes|required|array',
            'discount' => 'sometimes|required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            //code...
            $coupon = Coupon::where('coupon_code', $coupon_code)->firstOrFail();

            $coupon->update([
                'coupon_places'=>json_encode($request->coupon_places),
                'discount' => $request->discount
            ]
            );

        return response()->json(['message' => 'Coupon updated successfully', 'coupon' => $coupon], 201);

        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while deleting the record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteCoupon(Request $request,$coupon_code)
    {
        try {
            //code...
            $coupon = Coupon::where('coupon_code', $coupon_code)->firstOrFail();

            $coupon->delete();

            return response()->json(['message' => 'Record deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while deleting the record',
                'error' => $e->getMessage()
            ], 500);
        }

    }

}
