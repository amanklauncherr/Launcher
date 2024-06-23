<?php

namespace App\Http\Controllers;

use App\Models\QueAndAns;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QueAndAnsController extends Controller
{
    //
    public function addQueAndAns(Request $request){

        // $request->validate(([
        //     'Question' => 'required|string',
        //     'Answer' => 'required|string',
        // ]));

        // $data=$request->only(['Question', 'Answer']);

       
        //     QueAndAns::create($data);
        //     return response()->json(['message' => 'Question and Answer created'], 201);
        // // }

        $validator = Validator::make($request->all(), [
            'Question' => 'required|string',
            'Answer' => 'required|string',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Extract the validated data
            $data = $validator->validated();

            // Create a new question and answer entry
            QueAndAns::create($data);

            // Return a success response
            return response()->json(['message' => 'Question created'], 201);
        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while creating the question',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showQueAndAns()
    {
        $data =QueAndAns::all() ;
        if ($data->isEmpty()) {
            return response()->json(['message' => 'No Questions found'], 404);
        } else {
            return response()->json($data, 200);
        }
    }
}
