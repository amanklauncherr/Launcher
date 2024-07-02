<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployerProfile;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobPostingController extends Controller
{
    //
    public function showJobAdmin()
    {
        $job = JobPosting::with(['user'])->get();
        // $employer=EmployerProfile::get();
        if($job->isEmpty())
        {
            return response()->json(['error'=>'Nothing'],404);
        }
        return response()->json(['job'=>$job],200);
    }

    public function showJob()
    {
        $job = JobPosting::with(['user'])->get();
        // $employer=EmployerProfile::get();
        if($job->isEmpty())
        {
            return response()->json(['error'=>'Nothing'],404);
        }
        return response()->json(['job'=>$job],200);
    }
    
    public function empProfile(Request $request,$user_id){
        $employer=EmployerProfile::where('user_id',$user_id)->first();
        if(!$employer){
            return response()->json(['jobs' =>'Not Found'], 404);
        }
        return response()->json(['profile' => $employer], 200);
    }
    
// {
//     "gigs_type": "Freelance",
//     "gigs_about": "Travel Writer",
//     "company_name": "CODEEDGE",
//     "isVerified": true,
//     "gigs_description": "Calling all wordsmiths with a love for exploration! We're looking for freelance travel writers to craft engaging articles, destination guides, and travel narratives. Share your unique perspective and inspire readers to embark on their own adventures."
// },

    public function AddJob(Request $request)
    {
        $validator=Validator::make($request->all(),[
          'title' => 'required|string|max:50',
          'description' => 'nullable|string',
          'duration' => 'required|integer',
          'active' => 'boolean',
          'verified' => 'boolean',  
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            //code...
            $user = Auth::user();

            $jobData = $request->only(['title', 'description', 'duration', 'active', 'verified']);
            if (!isset($jobData['active'])) {
                $jobData['active'] = false;
            }
            if (!isset($jobData['verified'])) {
                $jobData['verified'] = false;
            }

            $newEmployer = JobPosting::create([
                'user_id' => $user->id,
                'title' => $jobData['title'],
                'description' => $jobData['description'],
                'duration' => $jobData['duration'],
                'active' => $jobData['active'],
                'verified' => $jobData['verified'],
            ]);
            return response()->json($newEmployer, 201);
        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while Adding Coupon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateJobActive(Request $request,$id)
    {
        try {
            //code...
            $job=JobPosting::findOrFail($id);

            $job->active = !$job->active;
    
            $job->save();
            
                return response()->json(["job" => $job], 200);
        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while updating active feild',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function updateJobVerified(Request $request,$id)
    {
        try {
            //code...
            $job=JobPosting::findOrFail($id);

            $job->verified = !$job->verified;
    
            $job->save();
            
                return response()->json(["job" => $job], 200);
        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while updating Verified feild',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
