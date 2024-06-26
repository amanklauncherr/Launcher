<?php

namespace App\Http\Controllers;

use App\Models\ClientInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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

            $client=ClientInfo::create($data);

            // $client->created_at = $client->created_at->format('Y-m-d');
            // $client->updated_at = $client->updated_at->format('Y-m-d');
    
            // Return a success response
            return response()->json(['message' => 'Client Added','Client'=>$client], 201);
        } catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while creating the question',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     public function updateClient(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'url' => 'sometimes|required|string',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            //code...
            $client = ClientInfo::findorFail($id);

            $data = $validator->validated();
         
            if($request->hasFile('image'))
            {
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
                
                $data['image']=$uploadedFileUrl;
            }

            $client->update($data);
            // $client->created_at = $client->created_at->format('Y-m-d');
            // $client->updated_at = $client->updated_at->format('Y-m-d');
    

            // Return a success response
            return response()->json(['message' => 'Client Updated', 'client' => $client], 200);
        }catch (ModelNotFoundException $e) {
            // Return a response if the record was not found
            return response()->json(['message' => 'Record not found'], 404);     
        }catch (\Exception $e) {
            // Return a custom error response in case of an exception
            return response()->json([
                'message' => 'An error occurred while updating the client',
                'error' => $e->getMessage()
            ], 500);
        }
     }

     public function deleteClient($id)
     {
         try {
             // Find the record by ID or fail if it doesn't exist
             $client = ClientInfo::findOrFail($id);
 
             // Delete the record
             $client->delete();
 
             // Return a success response
             return response()->json(['message' => 'Record deleted successfully'], 200);
         } catch (ModelNotFoundException $e) {
             // Return a response if the record was not found
             return response()->json(['message' => 'Record not found'], 404);
         } catch (\Exception $e) {
             // Handle any other exceptions
             return response()->json([
                 'message' => 'An error occurred while deleting the record',
                 'error' => $e->getMessage()
             ], 500);
         }
     } 

    public function showClient()
    {
        $data =ClientInfo::all();
        if ($data->isEmpty()) {
            return response()->json(['message' => 'No Client found'], 404);
        } else {
            return response()->json($data, 200);
        }
    }
}
