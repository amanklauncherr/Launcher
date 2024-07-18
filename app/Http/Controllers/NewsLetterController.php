<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscriptionConfirmation;
use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    //
    public function AddEmail(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=> 'required|email|max:35|unique:news_letters'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
                ], 422);
        }
        // try {
        //     //code...
        //     $data=$validator->validated();

        //     Mail::to($request->email)->send(new NewsletterSubscriptionConfirmation());

        //     // Check if the email was sent successfully
        //     if (Mail::send(new NewsletterSubscriptionConfirmation()) instanceof SendQueuedMailable) {
        //         // Email sent successfully
        //         NewsLetter::create($data);
        //         return response()->json(['message' => 'Email Added & Mail sent successfully'], 201);
        //     } else {
        //         // Failed to send email
        //         return response()->json(['message' => 'Failed to send confirmation email'], 500);
        //     }

        //     // Mail::to($request->email)->send(new NewsletterSubscriptionConfirmation());
            
        //     // $failedRecipients = Mail::failures();
        //     // if ($failedRecipients->isEmpty()) {
        //     //     return response()->json(['message' => 'Failed to send confirmation email','failuer'=>[$failedRecipients]], 500);
        //     // }

        //     // // $result=
        //     // NewsLetter::create($data);
        //     // // if(!$result)
        //     // // {
        //     // //     return response()->json(['message'=>'Email not saved'],400);
        //     // // }
        //     // return response()->json([
        //     //     'message' => 'Email Added'
        //     // ], 201);
        // } catch (\Exception $e) {
        //     //throw $th;
        //     return response()->json([
        //         'message' => 'An error occurred while Adding Email',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
        try {
            $data = $validator->validated();
    
            // Send confirmation email (using a try-catch block for potential exceptions)
            Mail::to($request->email)->send(new NewsletterSubscriptionConfirmation());

            // if (!$sent) {
            //     return response()->json([
            //         'message' => 'Error sending confirmation email.',
            //     ], 500);
            // }
            // // Save email address to database
            NewsLetter::create($data);
    
            return response()->json([
                'message' => 'Email Added Successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while Adding Email',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function ShowEmail(Request $request)
    {
        $result =NewsLetter::all();
        if($result->isEmpty())
        {
            return response()->json(['message' => 'No Quiz Response found'], 404);        }
        return response()->json($result,200);
    }
}
