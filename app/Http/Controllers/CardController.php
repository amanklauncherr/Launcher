<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CardController extends Controller
{
    //
    public function addCard(Request $request)
    {
        $card = Card::where('Card_No', $request->Card_No)->first();

        $validator = Validator::make($request->all(), [
            'Card_No' => 'required|string',
            'Card_Heading' => $card ? 'nullable|string|max:25' : 'required|string|max:25',
            'Card_Subheading' => $card ? 'nullable|string|max:35' : 'required|string|max:35',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $data = $validator->validated();

            if (!$card && Card::count() >= 3) {
                return response()->json([
                    'success'=> 0 ,
                    'message' => 'Cannot create more than 3 cards'
                ], 400);
            }

            if($card)
            {
                $card->update($data);
                return response()->json(['success'=> 1 ,'message' => 'Card updated'], 201);
            }else {
                Card::create($data);
                return response()->json(['success'=> 1 ,'message' => 'Card created'], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success'=> 0, 
                'message' => 'An error occurred while Adding or Updating Section',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
