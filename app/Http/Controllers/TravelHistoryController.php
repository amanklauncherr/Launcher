<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TravelHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelHistoryController extends Controller
{
    //
    public function GetTravelHistory(Request $request)
    {
        $History=TravelHistory::where('user_id',Auth::guard('api')->id())->get();

        if($History->isEmpty())
        {
            return response()->json(
                [
                    'success' => 0,
                    'error' => 'No Travel History'
                ]
            );
        }

        $data = [];

        foreach($History as $his)
        {
            $obj=[
                $his->user_id,
                $his->BookingType,
                $his->BookingRef,
                json_decode($his->PnrDetials),
                json_decode($his->PAXTicketDetails),
                json_decode($his->TravelDetails),
            ];
                array_push($data,$obj);
        }

        return response()->json(
            [
                'success' => 1,
                'message' => 'Travel History',
                'data'=> $data
            ]
        );       
    }
}
