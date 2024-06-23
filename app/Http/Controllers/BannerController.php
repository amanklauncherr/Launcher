<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BannerController extends Controller
{
    //
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banners.*.banner_heading' => 'required|string',
            'banners.*.banner_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Process each banner
        try {
            $banners = $request->banners;
    
            foreach ($banners as $banner) {
                // Upload image to Cloudinary
                $uploadedFileUrl = Cloudinary::upload($banner['banner_url']->getRealPath())->getSecurePath();
    
                // Create banner record
                Banner::create([
                    'banner_heading' => $banner['banner_heading'],
                    'banner_url' => $uploadedFileUrl
                ]);
            }
    
            return response()->json(['message' => 'Images uploaded successfully'], 201);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'message' => 'Error uploading banners',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showUpload()
    {
        $terms =Banner::all();
        if($terms->isEmpty())
        {
            return response()->json(['message' => 'No Banner found'], 404);
        }
        else {

            return response()->json($terms,200);
        }
    }
}



 