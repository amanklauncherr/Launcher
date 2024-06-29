<?php

namespace App\Http\Controllers;

// use App\Models\Banner;
use App\Models\BannerNew;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BannerController extends Controller
{
    //
    // public function upload(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'banners.*.banner_heading' => 'required|string',
    //         'banners.*.banner_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    
    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }
    
    //     // Process each banner
    //     try {
    //         $banners = $request->banners;
    
    //         foreach ($banners as $banner) {
    //             // Upload image to Cloudinary
    //             $uploadedFileUrl = Cloudinary::upload($banner['banner_url']->getRealPath())->getSecurePath();
    
    //             // Create banner record
    //             Banner::create([
    //                 'banner_heading' => $banner['banner_heading'],
    //                 'banner_url' => $uploadedFileUrl
    //             ]);
    //         }
    
    //         return response()->json(['message' => 'Images uploaded successfully'], 201);
    //     } catch (\Exception $e) {
    //         // Handle any exceptions
    //         return response()->json([
    //             'message' => 'Error uploading banners',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function Upload(Request $request)
    {
        $banner=BannerNew::where('Banner_No',$request->Banner_No)->first();
        // return response()->json(['banner'=>$banner]);
        $validator = Validator::make(
            $request->all(),[
                'Banner_No' => 'required|string',
                'Banner_heading' => 'nullable|string',
                'Banner_image' => $banner ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                //code...
                $data=$validator->validated();


                // $uploadedFileUrl = Cloudinary::upload($request->file('Banner_image')->getRealPath())->getSecurePath();

                // $data['Banner_image']=$uploadedFileUrl;
                // // Create banner record

                if ($request->hasFile('Banner_image')) {
                    $uploadedFileUrl = Cloudinary::upload($request->file('Banner_image')->getRealPath())->getSecurePath();
                    $data['Banner_image'] = $uploadedFileUrl;
                }

                // $banner= BannerNew::where('Banner_No',$request->Banner_No)->first();

                if($banner)
                {
                    $banner->update($data);
                    return response()->json(['message' => 'Banner updated'], 200);
                }else{
                    $data['Banner_heading'] = $request->input('Banner_heading', 'null');

                    BannerNew::create($data);
                    return response()->json(['message' => 'Banner created'], 201);
                }
            }catch (\Exception $e) {
                // Return a custom error response in case of an exception
                return response()->json([
                    'message' => 'An error occurred while Adding or Updating Section',
                    'error' => $e->getMessage()
                ], 500);
            }

    }

    public function showUpload()
    {
        $terms =BannerNew::all();
        if($terms->isEmpty())
        {
            return response()->json(['message' => 'No Banner found'], 404);
        }
        else {

            return response()->json($terms,200);
        }
    }
}



 