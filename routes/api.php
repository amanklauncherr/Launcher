<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\Sections;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CompanyDetailController;
use App\Http\Controllers\QueAndAnsController;
use App\Http\Controllers\ClientInfoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployerGigController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\UserProfileController;

// 
use App\Models\About;
use App\Models\Banner;
use App\Models\ClientInfo;
use App\Models\QueAndAns;
use App\Models\UserProfile;
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






Route::group(['middleware'=>'api','prefix'=>'auth'], function(){
    Route::post('/register',[AdminController::class,'register']);
    Route::post('/login',[AdminController::class,'login']);
    Route::get('/profile',[AdminController::class,'profile']);
    Route::post('/logout',[AdminController::class,'logout']);
    Route::get('/alluser',[AdminController::class,'allUser']);
    Route::post('/userRegister',[UserProfileController::class,'userRegister']);
    Route::post('/userLogin',[UserProfileController::class,'userLogin']);
});


Route::middleware(['auth:api','role:admin'])->group(function () {
    Route::put('/profile/update', [AdminController::class, 'updateProfile']);

    // t and c
    Route::post('/term-conditions',[TermsConditionsController::class, 'store']);

    // Section
    Route::post('/Add-Section',[Sections::class,'addSection']);

    // About
    Route::post('/Add-About',[AboutController::class,'addAbout']);
    
    // Details
    Route::post('/Add-Details', [CompanyDetailController::class, 'addDetail']);

    // Q and A
    Route::post('/Add-QueAndAns', [QueAndAnsController::class, 'addQueAndAns']);
    Route::put('/Update/QueAndAns/{id}',[QueAndAnsController::class,'updateQueAndAns']);
    Route::delete('/Delete/QueAndAns/{id}',[QueAndAnsController::class,'deleteQueAndAns']);

    // Banner
    Route::post('/Add-Banner',[BannerController::class,'Upload']);
    
    // coupon 
    Route::post('/Add-Coupon',[CouponController::class,'addCoupon']);
    Route::put('/Update-Coupon/{coupon_code}',[CouponController::class,'updateCoupon']);
Route::delete('/Delete-Coupon/{coupon_code}',[CouponController::class,'deleteCoupon']);

    // Client 
    Route::post('/Add-Client', [ClientInfoController::class, 'addClient']);
    Route::put('/Update/Client/{id}', [ClientInfoController::class, 'updateClient']);
    Route::delete('/Delete/Client/{id}', [ClientInfoController::class, 'deleteClient']);


   //  Job
   Route::post('/addJob',[JobPostingController::class,'AddJob']);
   Route::put('/updateJobActive/{id}',[JobPostingController::class,'updateJobActive']);
   Route::put('/updateJobVerified/{id}',[JobPostingController::class,'updateJobVerified']);
   Route::get('/job',[JobPostingController::class,'showJob']);
   Route::get('/emp/{user_id}',[JobPostingController::class,'empProfile']); //employer details for admin to see


});

Route::middleware(['auth:api','role:user'])->group(function () {
    //    userProfile
    Route::post('/addUserProfile',[UserProfileController::class,'AddUserProfile']);
    Route::get('/showUserProfile',[UserProfileController::class,'showUserProfile']);
    Route::put('/userPasswordUpdate',[UserProfileController::class,'passwordUpdateUser']);

});

Route::get('/Show-Client',[ClientInfoController::class,'showClient']);

Route::get('/Show-Banner',[BannerController::class,'showUpload']);

Route::get('/Show-Coupon',[CouponController::class,'showCoupon']);
Route::get('/Apply-Coupon',[CouponController::class,'applyCoupon']);

Route::get('/term-conditions',[TermsConditionsController::class,'show']);

Route::get('/Show-Section',[Sections::class,'showSection']);

Route::get('/Show-About',[AboutController::class,'showAbout']);

Route::get('/Show-Details',[CompanyDetailController::class,'showDetail']);

Route::get('/Show-QueAndAns',[QueAndAnsController::class,'showQueAndAns']);

