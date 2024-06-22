<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BannerController extends Controller
{
    //
    public function upload(Request $request)
    {
        $request->validate([
           '*.banner_name'=> 'string|unique', 
           '*.banner_heading'=> 'string',
           '*.banner_url'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $banners=$request->all();

        foreach($banners as $banner){
            $uploadedFileUrl = Cloudinary::upload($request->file('banner_url')->getRealPath())->getSecurePath();

            
        Banner::create([
            'banner_name' => $banner['banner_name'],
            'banner_heading' => $banner['banner_heading'],
            'banner_url' => $uploadedFileUrl
        ]);

        }
  
        return response()->json(['message' => 'images uploaded'], 201);
    }

    public function showUpload()
    {
        $terms =Banner::first();
        if($terms)
        {
            return response()->json($terms,200);
        }
        else {
            return response()->json(['message' => 'No Banner found'], 404);
        }
    }
}
