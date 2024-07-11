<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionCard;
use Illuminate\Support\Facades\Validator;

class SubscriptionCardController extends Controller
{
    //
    public function addSubCard(Request $request){

        try {
            $cardnoExists = SubscriptionCard::where('card_no', $request->card_no)->exists();
            $validator = Validator::make($request->all(), [
                'card_no' => 'required|string|unique:subscription_cards,card_no,' . $request->card_no . ',card_no',
                'title' => $cardnoExists ? 'nullable|string' : 'required|string',
                'price' => $cardnoExists ? 'nullable|string' : 'required|string',
                'price_2' => 'nullable|string',
                'features' => $cardnoExists ? 'nullable|array':'required|array',
                'buttonLabel' =>$cardnoExists ? 'nullable|string' : 'required|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $card = SubscriptionCard::where('card_no', $request->card_no)->first();
    
            if ($card) {
                $card->update([
                    'title' => $request->title ?? $card->title,
                    'price' => $request->price ?? $card->price,
                    'price_2' => $request->price_2 ?? $card->price_2,
                    'features' => json_encode($request->features ?? json_decode($card->features, true)),
                    'buttonLabel' => $request->buttonLabel ?? $card->buttonLabel,
                ]);
    
                // DB::commit();
    
                return response()->json(['Success' => 1, 'Message' => 'Updated Successfully'], 201);
            }
    
            SubscriptionCard::create([
                'card_no' => $request->card_no,
                'title' => $request->title,
                'price' => $request->price,
                'price_2' => $request->price_2,
                'features' => json_encode($request->features),
                'buttonLabel' => $request->buttonLabel,
            ]);
    
            // DB::commit();
    
            return response()->json(['Success' => 1, 'Message' => 'Card Added Successfully'], 201);
    
        } catch (\Exception $e) {
            // DB::rollBack();
    
            return response()->json([
                'message' => 'An error occurred while Adding Coupon',
                'error' => $e->getMessage()
            ], 500);
        }    }

    public function showSubCard()
    {
        // $plans = DB::table('your_table_name')->get();
        $plans = SubscriptionCard::all();

       $formattedPlans = [];

        foreach ($plans as $plan) {
            $formattedPlan = [
                'title' => $plan->title,
                'price' => $plan->price,
            ];

            if (!is_null($plan->price_2)) {
                $formattedPlan['price_2'] = $plan->price_2;
            }

            $formattedPlan['features'] = json_decode($plan->features);
            $formattedPlan['buttonLabel'] = $plan->buttonLabel;

            $formattedPlans[] = $formattedPlan;
        }

        return response()->json($formattedPlans);
    }

    public function showSubCardAdmin()
    {
        $cards=SubscriptionCard::all();
        if($cards->isEmpty()){
            return response()->json(['Message'=>'No Subscription Card Found'],40);
        }
        return response()->json(['Cards'=>$cards],200);
    }
}


