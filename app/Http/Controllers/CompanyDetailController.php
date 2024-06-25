<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CompanyDetailController extends Controller
{
    //
    public function addDetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string',
            'company_address' => 'required|string',
            'company_email' => 'required|email',
            'company_contact' => 'required|string',
            'company_timing' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
try {
    //code...
    $data = $validator -> validate();
    $companyDetails = CompanyDetails::first();

    if ($companyDetails) {
        $companyDetails->update($data);
        return response()->json(['message' => 'Company Details updated'], 200);
    } else {
        CompanyDetails::create($data);
        return response()->json(['message' => 'Company Details Created'], 201);
    }
} catch (\Exception $e) {
    // Return a custom error response in case of an exception
    return response()->json([
        'message' => 'An error occurred while Adding or Updating Company Details',
        'error' => $e->getMessage()
    ], 500);
}
}

    public function showDetail()
    {
        $details=CompanyDetails::first();
        if($details)
        {
            return response()->json($details,200);
        }
        else {
            return response()->json(['message' => 'No Details found'], 404);
        }
    }
}





