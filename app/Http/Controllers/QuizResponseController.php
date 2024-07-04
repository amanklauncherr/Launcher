<?php

namespace App\Http\Controllers;

use App\Models\QuizResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizResponseController extends Controller
{
    //
    public function AddQuiz(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:quiz_responses',
            'phone' => 'required|string|min:10|max:10|unique:quiz_responses',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
                ], 422);
        }
        try {
            //code...
            $data=$validator->validated();
            $savedAns=QuizResponse::create($data);        
            if(!$savedAns)
            {
                return response()->json(['message'=>'Answer Not saved. Some Error might occur'],400);
            }
                return response()->json([
                    'message' => 'Quiz Answered Properly ','User'=>[
                        'name'=>$savedAns->name,
                        'email'=>$savedAns->email,
                        'phone'=>$savedAns->phone],
                    'Answer'=>[
                        'Answer1'=>$savedAns->answer1,
                        'Answer2'=>$savedAns->answer2,
                        'Answer3'=>$savedAns->answer3]], 201);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred while Adding or Updating About info',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ShowQuiz()
    {
        $result=QuizResponse::all();
        

        if($result->isEmpty())
        {
            return response()->json(['message' => 'No Quiz Response found'], 404);        
        }
        return response()->json($result,200);
    }
}
