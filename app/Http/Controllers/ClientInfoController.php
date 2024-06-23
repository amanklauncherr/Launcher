<?php

namespace App\Http\Controllers;

use App\Models\ClientInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;


class ClientInfoController extends Controller
{
    //
    public function addClient(Request $request){


        $validator = Validator::make($request->all(), [
            'url' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Extract the validated data
            $data = $validator->validated();
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

            // Create a new question and answer entry
            $data['image'] = $uploadedFileUrl;

            ClientInfo::create($data);

            // Return a success response
            return response()->json(['message' => 'Client Added'], 201);
        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while creating the question',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showClient()
    {
        $data =ClientInfo::all() ;
        if ($data->isEmpty()) {
            return response()->json(['message' => 'No Client found'], 404);
        } else {
            return response()->json($data, 200);
        }
    }
}
