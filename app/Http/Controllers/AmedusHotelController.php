<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Services\AmadeusService;
   
class AmedusHotelController extends Controller
{
    protected $amadeusService;
    
    public function __construct(AmadeusService $amadeusService)
    {
        $this->amadeusService = $amadeusService;
    }
    
    public function getHotelsByCity(Request $request)
    {
        $request->validate([
            'cityCode' => 'required|string|max:3'
        ]);

        $cityCode = $request->input('cityCode');
        $hotels = $this->amadeusService->getHotelsByCity($cityCode);

        return response()->json($hotels);
    }
}

