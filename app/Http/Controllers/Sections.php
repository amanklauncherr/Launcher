<?php

namespace App\Http\Controllers;

use App\Models\Section;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Sections extends Controller
{
    //
    public function addSection(Request $request){

       
        $validator = Validator::make(
            $request->all(),[
                'section' => 'required|string',
                'heading' => 'required|string',
                'sub-heading' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                //code...
                $data=$validator->validated();

                $sections= Section::where('section',$request->section)->first();

                if($sections)
                {
                    $sections->update($data);
                    return response()->json(['message' => 'Section updated'], 200);
                }else{
                    Section::create($data);
                    return response()->json(['message' => 'Section created'], 201);
                }
            }catch (\Exception $e) {
                // Return a custom error response in case of an exception
                return response()->json([
                    'message' => 'An error occurred while creating the question',
                    'error' => $e->getMessage()
                ], 500);
            }

    }

    public function showSection()
    {
        $sections = Section::all();

        if ($sections) {
            return response()->json($sections, 200);
        } else {
            return response()->json(['message' => 'No terms and conditions found'], 404);
        }
    }
}
