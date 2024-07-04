<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    //
    public function AddEmail(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=> 'required|email|max:35|unique:news_letters'
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
            $result=NewsLetter::create($data);
            if(!$result)
            {
                return response()->json(['message'=>'Email not saved'],400);
            }
                return response()->json([
                    'message' => 'Email Added'], 201);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred while Adding or Updating About info',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ShowEmail(Request $request)
    {
        $result =NewsLetter::all();
        if($result->isEmpty())
        {
            return response()->json(['message' => 'No Quiz Response found'], 404);        }
        return response()->json($result,200);
    }
}
