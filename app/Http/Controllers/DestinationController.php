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
            'thumbnail_image' => $destination ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|min:250|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif,svg|min:250|max:5120',
            'images' => $destination ? 'nullable|array' : 'required|array',
            'images.*' => $destination ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|min:250|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif,svg|min:250|max:5120',
            'short_description' => $destination ? 'nullable|string' : 'required|string',
            'description' => $destination ? 'nullable|string' : 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $data = $validator->validated();
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
            return response()->json(['message' => 'No Destinations found'], 404);
        } else {
            $existingImages = [];

            foreach ($terms as $destination) {
                $images = json_decode($destination->images, true); // Decode images JSON to array
                $existingImages[] = [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'thumbnail_image' => $destination->thumbnail_image,
                    'short_description' => $destination->short_description,
                    'description' => $destination->description,
                    'images' => $images,
                    // Add other fields as needed
                ];
        }

    return response()->json($existingImages, 200);
    
            }   
    }
}
// |dimensions:ratio=16/9