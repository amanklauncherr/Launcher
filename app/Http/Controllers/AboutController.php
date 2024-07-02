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
       $about=About::first();
    //    return response()->json(['about'=>$about]);
       $validator=Validator::make($request->all(),[
            'heading' => $about ? 'nullable|string' : 'required|string',
            'content' => $about ? 'nullable|string' : 'required|string',        
            'url' =>  $about ? 'nullable|string' : 'required|string'
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
                // $about->created_at = $about->created_at->format('Y-m-d');
                // $about->updated_at = $about->updated_at->format('Y-m-d');
                return response()->json(['message' => 'About updated','About'=>$about], 201);
            }else{
                $aboutCreated=About::create($data);
        
                // $aboutCreated->created_at = $aboutCreated->created_at->format('Y-m-d');
                // $aboutCreated->updated_at = $aboutCreated->updated_at->format('Y-m-d');
        
                return response()->json(['message' => 'About Created','About'=>$aboutCreated], 201);
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
