<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\joinOffer;
use Illuminate\Support\Facades\Validator;

class JoinOfferController extends Controller
{
    //
    public function addJoinOffer(Request $request){

        $sectionExists = joinOffer::where('section', $request->section)->exists();
       
        $validator = Validator::make(
            $request->all(),[
                'section' => $sectionExists ? 'required|string' : 'required|string|unique:join_offers,section',
                'heading' => $sectionExists ? 'nullable|string' : 'required|string',
                'sub_heading' =>'nullable|string|max:1500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                //code...
                $data=$validator->validated();

                $sections= joinOffer::where('section',$request->section)->first();

                if($sections)
                {
                    $sections->update($data);
                    return response()->json(['message' => 'Join Offer Section updated'], 200);
                }else{

                    // $data['sub_heading'] = $request->input('sub_heading', " ");

                    joinOffer::create($data);
                    return response()->json(['message' => 'Join Offer Section created'], 201);
                }
            }catch (\Exception $e) {
                // Return a custom error response in case of an exception
                return response()->json([
                    'message' => 'An error occurred while Adding or Updating Join Offer Section',
                    'error' => $e->getMessage()
                ], 500);
            }

    }

    public function showJoinOffer()
    {

        try {
            // Fetch all sections
            $sections = joinOffer::all();
    
            // Check if sections exist
            if ($sections->isEmpty()) {
                return response()->json(['message' => 'No sections found'], 404);
            }
    
            $sectionsArray = [];
            $mainHeading = null;
            
            foreach ($sections as $section) {
                if ($section->section === 'MainHeading') {
                    $mainHeading = [
                        'heading' => $section->{'heading'} == null ? "" : $section->{'heading'},
                        'sub_heading' => $section->{'sub_heading'} == null ? "" : $section->{'sub_heading'},
                        'Cards' => []
                    ];
                } else {
                    $sectionsArray[$section->section] = [
                        'heading' => $section->heading,
                        'sub_heading' => $section->{'sub_heading'} == null ? "" : $section->{'sub_heading'},
                    ];
                }
            }
            
            // Convert the sectionsArray to the desired Cards format
            $cards = [];
            foreach ($sectionsArray as $key => $value) {
                $cards[] = [
                     'heading' => $value['heading'],
                    'subheading' => $value['sub_heading']
                ];
            }
            
            // Add the cards to the mainHeading
            if ($mainHeading) {
                $mainHeading['Cards'] = $cards;
            }
            
            return response()->json($mainHeading);
                
            // return response()->json($sectionsArray, 200);    
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching sections',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showJoinOfferAdmin()
    {
        $cards=joinOffer::all();
        if($cards->isEmpty()){
            return response()->json(['Message'=>'No Join Card Found'],40);
        }
        return response()->json(['Cards'=>$cards],200);
    }
}
