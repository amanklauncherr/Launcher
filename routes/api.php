<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\Sections;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CompanyDetailController;
use App\Http\Controllers\QueAndAnsController;
use App\Http\Controllers\ClientInfoController;
use App\Models\About;
use App\Models\Banner;
use App\Models\ClientInfo;
use App\Models\QueAndAns;
use Ramsey\Collection\Map\AbstractMap;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/term-conditions',[TermsConditionsController::class, 'store']);
Route::get('/term-conditions',[TermsConditionsController::class,'show']);

Route::post('/Add-Section',[Sections::class,'addSection']);
Route::get('/Show-Section',[Sections::class,'showSection']);

Route::post('/Add-About',[AboutController::class,'addAbout']);
Route::get('/Show-About',[AboutController::class,'showAbout']);


Route::post('/Add-Details', [CompanyDetailController::class, 'addDetail']);
Route::get('/Show-Details',[CompanyDetailController::class,'showDetail']);

Route::post('/Add-QueAndAns', [QueAndAnsController::class, 'addQueAndAns']);
Route::get('/Show-QueAndAns',[QueAndAnsController::class,'showQueAndAns']);

Route::post('/Add-Client', [ClientInfoController::class, 'addClient']);
Route::get('/Show-Client',[ClientInfoController::class,'showClient']);

Route::post('/Add-Banner',[BannerController::class,'upload']);
Route::get('/Show-Banner',[BannerController::class,'showUpload']);

