<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartDetailsController extends Controller
{
    //
    public function updateCart(Request $request)
    {
        $tokenType = $request->attributes->get('token_type');

        if ($tokenType === 'public') {
            return response()->json(['Success'=> 0, 'Message' => 'Unauthorized, Login To Add Cart']);
        } 
        elseif ($tokenType === 'user'){
            try {
                $productExist = CartDetails::where('product_id', $request->product_id)->exists();
                $validator = Validator::make($request->all(), [
                    'product_id' => 'nullable|integer',
                    'product_name' => $productExist ? 'nullable|string':'required|string',   
                    'quantity' => 'required|integer|min:0',
                    'price' => 'required|integer|min:1',
                ]);
            
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }
            
                $user = Auth::user();
            
                $data = $validator->validated();
                $total = $request->quantity * $request->price;
                $data['price'] = $total;
                $data['user_id'] = $user->id;
            
                $product = CartDetails::where('product_id', $request->product_id)->first();
                if ($productExist && $request->quantity>0) {
                    $product->update($data);
                    return response()->json(['message' => 'Cart updated','Cart'=>$product], 200);
                } else if($productExist && $request->quantity === 0){
                    $product->delete();
                    return response()->json(['message' => 'Product removed from cart'], 200);
                }
                else if(!$product && $request->quantity === 0)
                {
                    return response()->json(['Message'=>'Quantity should be greater than 0'],400);
                }
                else {
                    $finalCart = CartDetails::create($data);
                    return response()->json($finalCart);
                }
            } catch (\Exception $e) {
                // Return a custom error response in case of an exception
                return response()->json([
                    'message' => 'An error occurred while Adding or Updating Cart Section',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['success'=>0,'error' => 'Unauthorized.'], 401);
    }

    public function showCart(Request $request){
        
        $tokenType = $request->attributes->get('token_type');

        if ($tokenType === 'public') {
            return response()->json(['success'=> 0,'message' => 'Unauthorized, Login To Check Your Cart']);
        }
        elseif($tokenType === 'user'){
            $user=Auth::user();
            $totalCart=CartDetails::where('user_id',$user->id)->get();
            if($totalCart->isEmpty())
            {
                return response()->json(['message'=>'Please Add Some products in Your Cart'],404);
            }
            if ($request->has('products')) {
                foreach ($request->products as $productData) {
                    $product = CartDetails::where('user_id', $user->id)
                                        ->where('product_id', $productData['product_id'])
                                        ->first();    
                    if ($product) {
                        if ($productData['quantity'] > 0) {
                            $product->update(['quantity' => $productData['quantity']]);
                        $total = $productData['quantity'] * $productData['price'];
                        $product->update([
                            'quantity' => $productData['quantity'],
                            'price' => $total,
                        ]);
                        } else {
                            $product->delete();
                        }
                    }
                }
                $totalCart = CartDetails::where('user_id', $user->id)->get();
            }
    
            $total=$totalCart->sum('price');
            $gstAmount = $total * 0.18;
            $gstAmount=round($gstAmount, 2);
            $grand=$total + $gstAmount;
    
            // $products = $totalCart->map(function($product) {
            //     $productArray = $product->toArray();
            //     $productArray['single_price'] = $product->price / $product->quantity;
            //     return $productArray;
            // });

            $products = $totalCart->map(function($product) {
                $productArray = $product->toArray();
                $productArray['sub_total'] = $product->price;
                $productArray['price'] = $product->price / $product->quantity;
                unset($productArray['created_at']); // Remove the original 'price' key
                unset($productArray['updated_at']); // Remove the original 'price' key
                return $productArray;
            });
    
            return response()->json([
                'products'=>$products,
                'subTotal'=>$total,
                'gstAmt' => $gstAmount,
                'grand_Total'=>$grand],200);
            
        }
    }
}
