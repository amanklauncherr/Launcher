<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\JobPosting;
use App\Models\EmployerProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    //
    public function AddEnquiry(Request $request)
    {
        $tokenType = $request->attributes->get('token_type');

        if ($tokenType === 'public') {
            return response()->json(['Success'=> 0,'data' => 'Unauthorized, Login To Add Enquiry']);
        } elseif ($tokenType === 'user') {
            $user = $request->attributes->get('user');
            $validator=Validator::make($request->all(),[
                'gigID' => 'required|integer|exists:job_posting,id',
                'note' => 'nullable|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            try {
    
                $existingEnquiry = Enquiry::where('userID', $user->id)->where('gigID', $request->input('gigID'))->first();
    
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

        return response()->json(['error' => 'Unauthorized'], 401);


        // $user = Auth::user();
    }   
    
    public function showEnquiry(Request $request){
   
       $enquries=Enquiry::get();
   
       $gigIds=$enquries->pluck('gigID')->toArray();
   
       $jobPostings = JobPosting::whereIn('id', $gigIds)->get();
   
       $userId=$jobPostings->pluck('user_id')->unique();
   
       $employerProfileUserIds = EmployerProfile::pluck('user_id');
   
       $filteredUserIds = $userId->diff($employerProfileUserIds)->values()->toArray();
   
       $AdminGig=JobPosting::whereIn('user_id',$filteredUserIds)->get();
   
       $AdminGigArray=$AdminGig->pluck('id');
   
       $finalGigs=Enquiry::whereIn('gigID',$AdminGigArray)->with(['jobPosting','user.userProfile'])->get();
       
       $formattedData = $finalGigs->map(function ($finalGig) {
        return [
            'job_title' => $finalGig->jobPosting->title ?? 'N/A',
            'job_location' => $finalGig->jobPosting->location ?? 'N/A',
            'note' => $finalGig->note,
            'user_name' => $finalGig->user->name ?? 'N/A',
            'user_email' => $finalGig->user->email ?? 'N/A',
            'user_phone_no' => $finalGig->user->userProfile->user_Number ?? 'N/A',
        ];
    });

    return response()->json($formattedData, 200);

    }    

}
