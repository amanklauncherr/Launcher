<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\JobPosting;
use App\Models\EmployerProfile;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    //
    public function AddEnquiry(Request $request)
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
            $validator=Validator::make($request->all(),[
                'gigID' => 'required|integer|exists:job_posting,id',
                'note' => 'nullable|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            try {
                $existingEnquiry = Enquiry::where('userID', $user->id)->where('gigID', $request->input('gigID'))->first();
                if ($existingEnquiry) {
                    return response()->json(
                        [
                            'success' => 0,
                            'message'=>'User has already enquired for this Gig'
                        ], 422);
                }
                $enquiry = Enquiry::create([
                    'userID' => $user->id,
                    'gigID' => $request->input('gigID'),
                    'note' => $request->input('note') ? $request->input('note') : "" ,
                ]);
                return response()->json(['success'=>1,'enquiry'=>$enquiry], 201);
            } catch (\Exception $e) {
                // Return a custom error response in case of an exception
                return response()->json([
                    'success'=>0,
                    'message' => 'An error occurred while Adding Enquiry',
                    'error' => $e->getMessage()
                ], 500);
            }       
        }

        return response()->json(['success'=>0,'message' => 'Unauthorized'], 401);

        // $user = Auth::user();
    }   
    
    public function showEnquiry()
    {
   
            //    $enquries=Enquiry::get();
            //    if($enquries->isEmpty())
            //    { 
            //     return response()->json(['success'=>0,'message'=>'No Enquiry found'],400);
            //    }

       $jobs=DB::table('enquiries')
             ->leftJoin('job_posting','enquiries.gigID','=','job_posting.id')
             ->leftJoin('users','enquiries.userID','=','users.id')
             ->leftJoin('user_profiles','enquiries.userID','=','user_profiles.user_id')
             ->select(
                'job_posting.title as job_title',
                'job_posting.location as job_location',
                'users.name as user_name',
                'users.email as user_email',
                'user_profiles.user_Number as user_phone_no',
                'enquiries.note as note'
             )->get();
   
             if(!$jobs){
                return response()->json([
                    'success' => 0,
                    'error' => 'No Data Found'
                ], 404);
            }
                return response()->json(['success'=>1 ,'Enquires'=>$jobs]);

    }    

}

 //    $gigIds=$enquries->pluck('gigID')->toArray();
   
    //    $jobPostings = JobPosting::whereIn('id', $gigIds)->get();
   
    //    $userId=$jobPostings->pluck('user_id')->unique();
   
    //    $UserProfileIds = UserProfile::pluck('user_id');
   
    //    $filteredUserIds = $userId->diff($UserProfileIds)->values()->toArray();
   
    //    $AdminGig=JobPosting::whereIn('user_id',$filteredUserIds)->get();
   
    //    $AdminGigArray=$AdminGig->pluck('id');
   
    //    $finalGigs=Enquiry::whereIn('gigID',$AdminGigArray)->with(['jobPosting','user.userProfile'])->get();


    //    $formattedData = $finalGigs->map(function ($finalGig) {
    //     return [
    //         'job_title' => $finalGig->jobPosting->title ,
    //         'job_location' => $finalGig->jobPosting->location,
    //         'note' => $finalGig->note,
    //         'user_name' => $finalGig->user->name,
    //         'user_email' => $finalGig->user->email,
    //         'user_phone_no' => $finalGig->user->userProfile->user_Number ?? 'N/A',
    //     ];
    // });
    // return response()->json([$userId,$UserProfileIds,$filteredUserIds], 200);
    // return response()->json($formattedData, 200);
