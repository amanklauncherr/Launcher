<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployerProfile;
use App\Models\JobPosting;
// use App\Models\Section;
// use App\Models\User;
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

// {
//     "gigs_type": "Freelance",
//     "gigs_about": "Travel Writer",
//     "company_name": "CODEEDGE",
//     "isVerified": true,
//     "gigs_description": "Calling all wordsmiths with a love for exploration! We're looking for freelance travel writers to craft engaging articles, destination guides, and travel narratives. Share your unique perspective and inspire readers to embark on their own adventures."
// },

    public function showJob()
    {
        $jobs = JobPosting::with(['user.employerProfile'])->get();
        // $sectionGig = Section::where('section','Gigs')->get();
        // $employer=EmployerProfile::get();

        if($jobs->isEmpty())
        {
            return response()->json(['error'=>'Nothing in Gigs List'],404);
        }
        $jobsArray = $jobs->toArray();

        $newJobsArray = array_map(function($job){       
            return [
                'user_id' => $job['user_id'],
                'gigs_title' => $job['title'],
                'gigs_description' => $job['description'],
                'gigs_duration' => $job['duration'],
                'isActive' => $job['active'],
                'isVerified' => $job['verified'],
                'company_name' => $job['user']['employer_profile']['company_name'] ?? 'By Launcherr'
            ];
        }, $jobsArray);
        return response()->json(['gigs'=>$newJobsArray],200);
    }
    
    public function empProfile(Request $request,$user_id){
        $employer=EmployerProfile::where('user_id',$user_id)->first();
        if(!$employer){
            return response()->json(['jobs' =>'Not Found'], 404);
        }
        return response()->json(['profile' => $employer], 200);
    }
    
    public function AddJob(Request $request)
    {
        $validator=Validator::make($request->all(),[
          'title' => 'required|string|max:50',
          'description' => 'nullable|string',
          'duration' => 'required|integer',
          'active' => 'boolean',
          'verified' => 'boolean',  
          'location' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            //code...
            $user = Auth::user();

            $jobData = $request->only(['title', 'description', 'duration', 'active', 'verified','location']);
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
                'location' => $jobData['location'],
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
            
                return response()->json(["job" => $job], 201);
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
            
                return response()->json(["job" => $job], 201);
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

    public function searchJob(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'location' => 'nullable|string',
                'duration' => 'nullable|integer',
                'isVerified' => 'nullable|boolean',
            ]);
    
            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            // Initialize query builder for JobPosting model with eager loading
            $query = JobPosting::with(['user.employerProfile']);
    
            // Apply filters based on JSON payload
            if ($request->has('location')) {
                $query->where('location', 'like', '%' . $request->input('location') . '%');
            }
    
            if ($request->has('duration')) {
                $duration = $request->input('duration');
                if ($duration == 1) {
                    $query->where('duration', $duration);
                } else {
                    $query->where('duration', '<=', $duration);
                }
            }
    
            if ($request->has('isVerified')) {
                $query->where('verified', $request->input('isVerified'));
            }
    
            $searchResults = $query->get();
    
            // Return JSON response with search results
            $jobsArray = $searchResults->toArray();
    
            $newJobsArray = array_map(function($job) {
                return [
                    'user_id' => $job['user_id'],
                    'gigs_title' => $job['title'],
                    'gigs_description' => $job['description'],
                    'gigs_duration' => $job['duration'],
                    'isActive' => $job['active'],
                    'isVerified' => $job['verified'],
                    'company_name' => isset($job['user']['employer_profile']) ? $job['user']['employer_profile']['company_name'] : 'By Launcherr',
                    'gigs_location' => $job['location'],
                ];
            }, $jobsArray);
    
            return response()->json(['job' => $newJobsArray], 200);
        }  catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred while Adding or Updating About info',
                'error' => $e->getMessage()
            ], 500);
        }

    }

}
