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
use App\Http\Controllers\AirlineCodeController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\QuizResponseController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\CitesController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CartDetailsController;
use App\Http\Controllers\CountryCodeController;
use App\Http\Controllers\DestinationController;
// use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JoinOfferController;
use App\Http\Controllers\SubscriptionCardController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\IataCodeController;
use App\Http\Controllers\OrderIDCreationController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubscriptionDetailController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\Payment\PaymentController;

use App\Models\Destination;
use App\Models\SubscriptionDetail;
use App\Http\Middleware\CheckBearerToken;

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
    // Admin
    Route::post('/register',[AdminController::class,'register']);
    Route::post('/login',[AdminController::class,'login']);

    Route::post('/logout',[AdminController::class,'logout']);
    Route::get('/alluser',[AdminController::class,'allUser']);

    // User
    Route::post('/userRegister',[UserProfileController::class,'userRegister']);
    Route::post('/userLogin',[UserProfileController::class,'userLogin']);
});



Route::middleware(['check.bearer.token','role:admin'])->group(function () {

    Route::get('/admin/profile',[AdminController::class,'profile']);

    Route::put('/profile/update', [AdminController::class, 'updateProfile']);

    // Route::post('/refresh',[AdminController::class,'refresh']);

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
    
    // Coupon 
    Route::post('/Add-Coupon',[CouponController::class,'addCoupon']);
    Route::put('/Update-Coupon/{coupon_code}',[CouponController::class,'updateCoupon']);
    Route::delete('/Delete-Coupon/{coupon_code}',[CouponController::class,'deleteCoupon']);

    // Client 
    Route::post('/Add-Client', [ClientInfoController::class, 'addClient']);
    Route::put('/Update/Client/{id}', [ClientInfoController::class, 'updateClient']);
    Route::delete('/Delete/Client/{id}', [ClientInfoController::class, 'deleteClient']);

   // Job
   Route::post('/addJob',[JobPostingController::class,'AddJob']);
   Route::put('/updateJobActive/{id}',[JobPostingController::class,'updateJobActive']);
   Route::put('/updateJobVerified/{id}',[JobPostingController::class,'updateJobVerified']); 
   // Route::put('/updateBadge/{id}',[JobPostingController::class,'updateBadge']); 
   Route::get('/showJobs/Admin',[JobPostingController::class,'showJobAdmin']);
   Route::get('/emp/{user_id}',[JobPostingController::class,'empProfile']); //employer details for admin to see
   Route::post('/updateJob/{id}',[JobPostingController::class,'updateJob']);
   
   // Card
   Route::post('/addCard',[CardController::class,'addCard']);

  // Join Offer 
  Route::post('/addJoinOffer',[JoinOfferController::class,'addJoinOffer']);
  Route::get('/showJoinOfferAdmin',[JoinOfferController::class,'showJoinOfferAdmin']);

    //   Subscription Card
    Route::post('/addSubCard',[SubscriptionCardController::class,'addSubCard']);
    Route::get('/showSubCardAdmin',[SubscriptionCardController::class,'showSubCardAdmin']);

    Route::post('/addDestination',[DestinationController::class,'addDestination']);
    Route::delete('/deleteDestination',[DestinationController::class,'deleteDestination']);

});

Route::post('/add/Subscription',[SubscriptionDetailController::class,'addSubscription']);

Route::post('/add/User/Subscription',[UserSubscriptionController::class,'subscribeUser']);

Route::get('/showDestination',[DestinationController::class,'showDestination']);
Route::get('/destination',[DestinationController::class,'destination']);
Route::post('/searchDestination',[DestinationController::class,'searchDestination']);
Route::get('/destinationType',[DestinationController::class,'destinationType']);

Route::middleware(['publictokenOrauth'])->group(function () {
    //    userProfile
    Route::post('/addUserProfile',[UserProfileController::class,'AddUserProfile']);
    Route::get('/showUserProfile',[UserProfileController::class,'showUserProfile']);
    Route::put('/userPasswordUpdate',[UserProfileController::class,'passwordUpdateUser']);

    // Enquiry
    Route::post('/addEnquiry',[EnquiryController::class,'AddEnquiry']);

    // Search Gigs
    Route::get('/searchJob',[JobPostingController::class,'searchJob']);

    // Single Gig Info
    Route::get('/showJob',[JobPostingController::class,'showJob']);

    // Add to cart
    Route::post('/updateCart',[CartDetailsController::class,'updateCart']); 
    Route::post('/showCart',[CartDetailsController::class,'showCart']); 

    // Add User Subscription
    Route::post('/add/User/Subscription',[UserSubscriptionController::class,'subscribeUser']);

   
 
});



Route::post('/initiate', [PaymentController::class, 'initiatePayment']);
Route::any('phonepe-response',[PaymentController::class,'response'])->name('response');

 // payment
 Route::post('/payment-callback', [PaymentController::class, 'paymentCallback']);
 Route::get('/payment-redirect', function () 
 {
     // Handle the redirect after payment
     return response()->json(['message' => 'Redirect after payment']);
 });

// Route::post('/updateProfile',[EmployerController::class,'update']);

Route::post('/add',[IataCodeController::class,'addIata']);

Route::get('/showCode',[CountryCodeController::class,'showCountryCode']);

Route::get('/verified/{uniqueCode}',[UserVerificationController::class,'verify']);

Route::get('/showEnquiry',[EnquiryController::class,'showEnquiry']);

Route::post('/AddQuiz',[QuizResponseController::class,'AddQuiz']);

Route::get('/ShowQuiz',[QuizResponseController::class,'ShowQuiz']);

Route::post('/AddEmail',[NewsLetterController::class,'AddEmail']);

Route::get('/ShowEmail',[NewsLetterController::class,'ShowEmail']);

Route::get('/Show-Client',[ClientInfoController::class,'showClient']);

Route::get('/Show-Banner',[BannerController::class,'showUpload']);

Route::get('/Show-Coupon',[CouponController::class,'showCoupon']);

Route::get('/Apply-Coupon',[CouponController::class,'applyCoupon']);

Route::get('/term-conditions',[TermsConditionsController::class,'show']);

Route::get('/Show-Section',[Sections::class,'showSection']);

Route::get('/Show-About',[AboutController::class,'showAbout']);

Route::get('/Show-Details',[CompanyDetailController::class,'showDetail']);

Route::get('/Show-QueAndAns',[QueAndAnsController::class,'showQueAndAns']);

Route::get('/cities',[CitesController::class,'Cites']);

Route::get('/showJoinOffer',[JoinOfferController::class,'showJoinOffer']);

Route::get('/showSubCard',[SubscriptionCardController::class,'showSubCard']);

// All iata
Route::get('/showIata',[IataCodeController::class,'showIata']);

// Iata by query
Route::get('/showIata/airport',[IataCodeController::class,'showAirport']);

Route::get('/show/Airline',[AirlineCodeController::class,'showAirlineCode']);

Route::get('/showState',[StateController::class,'showState']);


// ORDERID
Route::post('/OrderID',[OrderIDCreationController::class,'AddOrderID']);


// PAYPAL
Route::post('/paypal',[PaymentController::class,'paypal']);

Route::get('/success',[PaymentController::class,'success'])->name('success');
 // payment
 Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');

