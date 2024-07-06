<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Card;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AboutController extends Controller
{
    //
    public function addAbout(Request $request)
    {
       $about=About::first();
       // return response()->json(['about'=>$about]);
       $validator=Validator::make($request->all(),[
            'heading' => $about ? 'nullable|string' : 'required|string',
            'content' => $about ? 'nullable|string' : 'required|string',        
            'url' =>  $about ? 'nullable|url' : 'required|url',
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
        $cards = Card::get();
        $url=
        [
            "https://res.cloudinary.com/douuxmaix/image/upload/v1720289812/m7pzdvuezcuetbrzqlek.png",
            "https://res.cloudinary.com/douuxmaix/image/upload/v1720289779/vz2x9n2ualplwvlg0f9m.png",
            "https://res.cloudinary.com/douuxmaix/image/upload/v1720289651/jvmktrilyvzbl37mucxd.png",


        ];


        if ($terms && $cards) {
            $cardArray = [];
    
            // Loop through cards and assign URLs sequentially
            foreach ($cards as $index => $card) {
                $cardArray[] = [
                    "Card_No" => $card['Card_No'],
                    "Card_Heading" => $card['Card_Heading'],
                    "Card_Subheading" => $card['Card_Subheading'],
                    "Card_Image" => isset($url[$index]) ? $url[$index] : null,
                ];
            }
    
            return response()->json([
                'heading' => $terms->heading,
                'content' => $terms->content,
                'url' => $terms->url,
                'Cards' => $cardArray
            ], 200);
        } else {
            return response()->json(['message' => 'No About section found'], 404);
        }
    }
}
