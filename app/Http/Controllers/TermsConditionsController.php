<?php

namespace App\Http\Controllers;
use App\Models\TermsCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TermsConditionsController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $terms= TermsCondition::first();
        // return response()->json(['message' => $terms], 200);
        if ($terms) {
            $terms->update(['content' => $request->content]);
            return response()->json(['message' => 'Terms and conditions updated'], 200);
        } else {
            TermsCondition::create(['content' => $request->content]);
            return response()->json(['message' => 'Terms and conditions created'], 201);
        }
    }

    public function show()
    {
        $terms =TermsCondition::first();
        if($terms)
        {
            return response()->json($terms,200);
        }
        else {
            return response()->json(['message' => 'No terms and conditions found'], 404);
        }
    }

    
}
