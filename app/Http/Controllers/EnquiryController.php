<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    //
    public function AddEnquiry(Request $request)
    {
        $user = Auth::user();
        $validator=Validator::make($request->all(),[
            'gigID' => 'required|integer|exists:job_posting,id',
            'note' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {

            $existingEnquiry = Enquiry::where('userID', $user->id)
                                 ->where('gigID', $request->input('gigID'))
                                 ->first();

        // If an enquiry already exists, return a response indicating so
        if ($existingEnquiry) {
            return response()->json(['success' => 0,'message'=>'User has already enquired for this Gig'], 422);
        }
        // Create a new enquiry if no existing enquiry is found
        $enquiry = Enquiry::create([
            'userID' => $user->id,
            'gigID' => $request->input('gigID'),
            'note' => $request->input('note'),
        ]);
        return response()->json(['success'=>1,'enquiry'=>$enquiry], 201);
        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while Adding Coupon',
                'error' => $e->getMessage()
            ], 500);
        }   
    }

   public function showEnquiry(Request $request){
     $enquries=Enquiry::get();
     if($enquries->isEmpty())
     {
        return response()->json(['Message' => 'Enquires Not Found'],404);
     }
     return response()->json(['enquires'=>$enquries]);
   } 
    
}
