<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DestinationController extends Controller
{
    //
    public function addDestination(Request $request){
        $params = $request->query('id');
        $destination = Destination::where('id', $params)->first();
    
        $validator = Validator::make($request->all(), [
            'name' => $destination ? 'nullable|string' : 'required|string',
            'city' => 'nullable|string',
            'state' => $destination ? 'nullable|string' : 'required|string',
            'destination_type' => $destination ? 'nullable|string' : 'required|string',
            'thumbnail_image' => $destination ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg' : 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'images' => $destination ? 'nullable|array' : 'required|array',
            'images.*' => $destination ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg' : 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'short_description' => $destination ? 'nullable|string' : 'required|string',
            'description' => $destination ? 'nullable|string' : 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $validator->validated();
            if(!isset($data['city']))
            {
                $data['city'] = '';
            }
            if ($request->hasFile('thumbnail_image')) {
                $urlthumbnailPath = Cloudinary::upload($request->file('thumbnail_image')->getRealPath())->getSecurePath();
                $data['thumbnail_image'] = $urlthumbnailPath;
            }
    
            if ($destination) {
                if ($request->hasFile('images')) {
                    $existingImages = json_decode($destination['images'], true); // Decode existing images from JSON
        
                    foreach ($request->file('images') as $index => $image) {
                        $urlImagePath = Cloudinary::upload($image->getRealPath())->getSecurePath();
                        $existingImages[$index] = $urlImagePath; // Update specific image index
                    }
        
                    $data['images'] = json_encode($existingImages); // Encode updated images back to JSON
                }
    
                $destination->update($data);
                return response()->json(['message' => 'Destination Updated'], 201);
            }
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $urlImagePath = Cloudinary::upload($image->getRealPath())->getSecurePath();
                    $imagePaths[] = $urlImagePath;
                }
                $data['images'] = json_encode($imagePaths);
            }

            Destination::create($data);
            return response()->json(['message' => 'Destination Added'], 201);
    
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong', 'details' => $th->getMessage()], 500);
        }
    }

    public function showDestination(){
           $terms = Destination::all();

        if ($terms->isEmpty()) {
            return response()->json(['success'=>0,'message' => 'No Destinations found'], 404);
        } else {
            $existingImages = [];

            foreach ($terms as $destination) {
                $images = json_decode($destination->images, true); // Decode images JSON to array
                $existingImages[] = [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'city' => $destination->city,
                    'state' => $destination->state,
                    'destination_type'=> $destination->destination_type,
                    'thumbnail_image' => $destination->thumbnail_image,
                    'images' => $images,
                    'short_description' => $destination->short_description,
                    'description' => $destination->description,
                    // Add other fields as needed
                ];
        }

    return response()->json(['success'=>1,'data'=>$existingImages], 200);
            }   
    }

    public function destination(Request $request){
        try {
            // Retrieve the 'id' from the query parameters
            $params = $request->query('id');
    
            // Fetch the destination record by id
            $terms = Destination::where('id', $params)->get();
    
            if ($terms->isEmpty()) {
                return response()->json(['success'=>0,'message' => 'Destination not found'], 404);
            }
    
            $terms[0]->makeHidden(['created_at', 'updated_at']);

            // Encode the 'images' attribute to JSON
            $terms[0]->images = json_decode($terms[0]->images);
    
            // Return the response as JSON
            return response()->json(['success'=>1,'destination'=>$terms[0]], 200);
        } catch (\Throwable $th) {
            return response()->json(['success'=>0,'message' => 'Something went wrong', 'details' => $th->getMessage()], 500);
        }
    }

    public function searchDestination(Request $request){
        try {
            //code...
            $params=$request->all();
            $validator= Validator::make($params,[
              'state' => 'nullable|string',
              'destination_type' =>'nullable|string',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all(); // Get all error messages
                $formattedErrors = [];
        
                foreach ($errors as $error) {
                    $formattedErrors[] = $error;
                }
                return response()->json([
                    'success' => 0,
                    'errors' => $formattedErrors
                ], 422);
            }   
            $query=Destination::query();
            if(!empty($params['state']))
            {
                $query->where('state', 'like', '%' . $params['state'] . '%');
            }
            if(!empty($params['destination_type']))
            {
                $query->where('destination_type', 'like', '%' . $params['destination_type'] . '%');
            }

            $searchResults = $query->get();
            if($searchResults->isEmpty())
            {
                return response()->json(['success' => 0, 'message'=>'No destination Found'], 404);  
            }
            return response()->json(['success' => 1,'Destination' => $searchResults], 200);     
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Something went wrong', 'details' => $th->getMessage()], 500);
        }
    }

    public function destinationType(){
    
    try {
        // Get all Destination records
        $types = Destination::all();

        if(!$types){
            return response()->json(['success'=>0,'message'=>'No data Found'], 404);       
        }

        $uniqueTypes = $types->pluck('destination_type')->unique()->values();
        // Return the unique destination types in a JSON response
        return response()->json(['success'=>1,'destination_types' => $uniqueTypes], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => 0,
            'error' => 'Something went wrong', 
            'details' => $th->getMessage()], 500);
    }
    }

    public function deleteDestination(Request $request){
        try {
            //code...
            $params = $request->query('id');
            $destination = Destination::where('id', $params)->first();
            if(!$destination)
            {
                return response()->json(['success'=>0,'message'=>'No Data Found'],404);
            }
            $destination->delete();
            return response()->json(['success'=>1,'message'=>'Destination Removed Successfully'],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'error' => 'Something went wrong while deleating ', 
                'details' => $th->getMessage()], 500);
        }

    }
}
// |dimensions:ratio=16/9
