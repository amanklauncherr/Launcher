<?php

namespace App\Http\Controllers;

use App\Models\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AboutController extends Controller
{
    //
    public function addAbout(Request $request)
    {
       
        $validator=Validator::make($request->all(),[
            'heading' => 'required|string',
            'content' => 'required|string',        
            'url' => 'required|string'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
                ], 422);
        }

        try {
            $data=$validator -> validated();
            $about = About::first();
    
            if($about){
                $about->update($data);
                return response()->json(['message' => 'About updated'], 200);
            }else{
                About::create($data);
                return response()->json(['message' => 'About Created'], 201);
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred while Adding or Updating About info',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function showAbout()
    {
        $terms =About::first();
        if($terms)
        {
            return response()->json($terms,200);
        }
        else {
            return response()->json(['message' => 'No About section found'], 404);
        }
    }
}
