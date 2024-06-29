<?php

namespace App\Http\Controllers;

use App\Models\QueAndAns;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function updateQueAndAns(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'Question' => 'sometimes|required|string',
            'Answer' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            //code...
            $QA= QueAndAns::findorFail($id);
            
                if ($request->filled('Question')) {
                    $QA->Question = $request->Question;
                }
        
                if ($request->filled('Answer')) {
                    $QA->Answer = $request->Answer;
                }

                $QA->save();

                return response()->json(['message' => 'Q&A updated successfully', 'Q&A' => $QA], 200);
            

        }catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error While Updating Q&A',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteQueAndAns($id)
    {
        try {
            // Find the record by ID or fail if it doesn't exist
            $queAndAns = QueAndAns::findOrFail($id);

            // Delete the record
            $queAndAns->delete();

            // Return a success response
            return response()->json(['message' => 'Record deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while deleting the record',
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
