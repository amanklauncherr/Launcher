<?php

namespace App\Http\Controllers;
use App\Models\TermsCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Tymon\JWTAuth\Facades\JWTAuth;



class TermsConditionsController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
                'content' => 'required|string',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            //code...
            $data=$validator->validated();

            $terms= TermsCondition::first();
            // return response()->json(['message' => $terms], 200);
            if ($terms) {
                $terms->update($data);
                return response()->json(['message' => 'Terms and conditions updated'], 200);
            } else {
                TermsCondition::create($data);
                return response()->json(['message' => 'Terms and conditions created'], 201);
            }
        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while creating the question',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function show()
    {
        $terms =TermsCondition::all();
        if($terms)
        {
            return response()->json($terms,200);
        }
        else {
            return response()->json(['message' => 'No terms and conditions found'], 404);
        }
    }

    
}
