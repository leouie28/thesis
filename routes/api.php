<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderProductController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\OtpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware'=>['auth:api']],function(){
    //Employee Profile
    Route::get('employeedetails',[ProfileController::class,'employeeDetails']);
    Route::post('update-profile',[ProfileController::class,'updateProfile']);
    Route::post('changepassword',[ProfileController::class,'changePassword']);
    Route::post('logout',[AuthController::class,'logout']);

    //Product
    Route::get('products',[ProductController::class, 'index']);
    Route::get('product-show/{id}',[ProductController::class, 'show']);

    //Customer
    Route::get('customers',[CustomerController::class, 'index']);
    Route::get('customer-show/{id}',[CustomerController::class, 'show']);
    Route::post('customer/store',[CustomerController::class,'store']);

    //Order
    Route::get('orders',[OrderController::class,'index']);
    Route::get('order-show/{id}',[OrderController::class,'show']);

    //Payment
    // Route::post('payment/{id}',[PaymentController::class,'store']);

    //Cart
    Route::get('cart',[CartController::class,'index']);
    Route::get('cart/{id}',[CartController::class,'show']);
    Route::get('deletecart/{id}',[CartController::class,'destroy']);
    Route::post('addtocart',[CartController::class,'store']);
    Route::post('updatecart/{id}',[CartController::class,'update']);

    //Order Product
    Route::get('customerorders/{id}',[OrderProductController::class,'customerOrders']);
    Route::get('deleteorder/{id}',[OrderProductController::class,'destroy']);
    Route::get('orderproduct',[OrderProductController::class,'index']);
    Route::get('orderproduct/{id}',[OrderProductController::class,'show']);
    Route::get('toprepared',[OrderProductController::class,'toPrepared']);
    Route::post('confirmedorder/{id}',[OrderProductController::class,'confirmedOrder']);
    Route::post('markprepared/{id}',[OrderProductController::class,'markPrepared']);
    Route::post('orderproduct/store',[OrderProductController::class,'store']);
    Route::post('paymentorder/{id}',[OrderProductController::class,'payment']);
    Route::post('updateorder/{id}',[OrderProductController::class,'update']);

    //Forgot Password
    Route::any('request_otp',[AuthController::class, 'requestOtp']);
    Route::post('verify_otp',[AuthController::class, 'verifyOtp']);
    Route::post('new_password',[AuthController::class, 'newPassword']);
});