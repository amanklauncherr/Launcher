<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartDetails;
use GuzzleHttp\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Cashfree\Cashfree;
use Cashfree\Model\CreateOrderRequest;
use Cashfree\Model\CustomerDetails;
use Cashfree\Model\OrderMeta;
use Illuminate\Support\Facades\DB;


class CashFreeController extends Controller
{
   
    // public function Cashfree_Create_order(Request $request){

    //     $phone = "8853309666";
    //     $amount = "1";
    //     $email = "amankumar@launcherr.co";
    //     $name = "Aman kumar";
    //     $user_id = 1;
    //     $refrence_number = "Test";
    //     $order_type = "flight";
    //     $extra = [
    //         'userRef' => $request->userRef,
    //         'baseAmount' => $request->baseAmount
    //     ];
    //     $currency = 'INR';

       
        
    //     $cashfree = new Cashfree();
    //     $order_id = 'launcherr_' . date('YmdHis');
    //     $order_amount = $amount;
    //     $customerID = "customer_" . rand(11111,99999);
    //     $return_url = "https://api.launcherr.co/api/success/Cashfree".$order_id;
        
    //     $create_orders_request = new CreateOrderRequest();
    //     $create_orders_request->setOrderId($order_id);
    //     $create_orders_request->setOrderAmount($order_amount);
    //     $create_orders_request->setOrderCurrency($currency);

    //     $customer_details = new CustomerDetails();
    //     $customer_details->setCustomerId($customerID);
    //     $customer_details->setCustomerPhone($phone);
    //     $customer_details->setCustomerEmail($email);
    //     $customer_details->setCustomerName($name);
    //     $create_orders_request->setCustomerDetails($customer_details);

    //     $order_meta = new OrderMeta();
    //     $order_meta->setReturnUrl($return_url);
    //     $create_orders_request->setOrderMeta($order_meta);

    //     try {
    //         $result = $cashfree->PGCreateOrder($x_api_version, $create_orders_request);
            
    //         DB::table('payments')->insert([
    //             'user_id' => $user_id,
    //             'order_id' => $order_id,
    //             'cf_order_id' => $result[0]['cf_order_id'],
    //             'amount' => $result[0]['order_amount'],
    //             'order_currency' => $result[0]['order_currency'],
    //             'refrence_number' => $refrence_number,
    //             'status' => 'Pending',
    //             'order_type' => $order_type,
    //             'extra' => json_encode($extra),
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);


    //         $payment_session_id = $result[0]['payment_session_id'];
    //         // return $payment_session_id;
    //         return view('pay_page', compact('payment_session_id'));
    //     } catch (Exception $e) {
    //         echo "Exception: " . $e->getMessage();
    //     }
    // }

    // public function PaymentSuccessCashFree($orderId)
    // {
       
        
    //     $cashfree = new Cashfree();

    //     try {
    //         $response = $cashfree->PGFetchOrder("2022-09-01", $orderId);
    //         // dd($response);
    //         if($response[1] === 200){
    //                 DB::table('payments')->where('order_id', $orderId)
    //                              ->update([
    //                               'status' => $response[0]['order_status'],
    //                               'updated_at' => now()
    //                              ]);

    //                $redirect =  DB::table('payments')->where('order_id', $orderId)->first();

    //                 if($redirect->order_type === 'flight'){
    //                     return redirect()->away('https://launcherr.co/flights');
    //                 }else if($redirect->order_type === 'bus'){
    //                     return redirect()->away('https://launcherr.co/bus');
    //                 } else if($redirect->order_type === 'products'){
    //                     return redirect()->away('https://launcherr.co/products');
    //                 } else{
    //                     return redirect()->away('https://launcherr.co');
    //                 }            
                
    //                 //  return view('payment-success', compact('response'));
    //         }
    //     } catch (Exception $e) {
    //         echo 'Exception when calling PGFetchOrder: ', $e->getMessage(), PHP_EOL;
    //     }

    // }

    // public function cancel()
    // {
    //     $redurectionUrl = 'https://launcherr.co/paymentFailure';
    //     return redirect()->away($redurectionUrl);
    // }

   

}
