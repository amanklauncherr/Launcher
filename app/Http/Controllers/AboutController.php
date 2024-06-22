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
        $request->validate(([
            'heading' => 'required|string',
            'content' => 'required|string',        
            'url' => 'required|string'
        ]));

        $data=$request->only(['heading','content','url']);
        $about = About::first();

        if($about){
            $about->update($data);
            return response()->json(['message' => 'About updated'], 200);
        }else{
            About::create($data);
            return response()->json(['message' => 'About Created'], 201);
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
