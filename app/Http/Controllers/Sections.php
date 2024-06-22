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

        $request->validate(([
            'section' => 'required|string',
            'heading' => 'required|string',
            'sub-heading' => 'required|string',
        ]));

        $data=$request->only(['section', 'heading', 'sub-heading']);

        $sections= Section::where('section',$request->section)->first();
        // return response()->json(['message' => $sections], 200);
        if($sections)
        {
            $sections->update($data);
            return response()->json(['message' => 'Section updated'], 200);
        }else{
            Section::create($data);
            return response()->json(['message' => 'Section created'], 201);
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
