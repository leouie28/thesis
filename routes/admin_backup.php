<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\Backoffice\AuthController;
// use App\Http\Controllers\Backoffice\ImageController;

Route::post('login',[AuthController::class, 'adminLogin'])->name('adminLogin');
Route::get('checkadmin',[AuthController::class,'checkAdmin'])->name('checkAdmin');
Route::group(['middleware'=>['auth:admin']],function(){

    //Ngadi isulod an iyo routes
    Route::get('logout',[AuthController::class,'adminLogout']);

    //Dashboard section
    Route::get('dashboard/company', [DashboardController::class, 'indexCompany']);
    Route::get('dashboard/employee', [DashboardController::class, 'indexEmployee']);
    Route::get('dashboard/product', [DashboardController::class, 'indexProduct']);
    Route::get('dashboard/customer', [DashboardController::class, 'indexCustomer']);

    //Company section
    Route::get('company', [CompanyController::class, 'index']);
    Route::post('company/create', [CompanyController::class, 'store']);
    Route::put('company/update/{id}', [CompanyController::class, 'update']);
    Route::delete('company/destroy/{id}', [CompanyController::class, 'destroy']);
    Route::put('company/updateStatus/{id}', [CompanyController::class, 'updateStatus']);

    //Employee section
    Route::get('employee', [EmployeeController::class, 'index']);
    Route::post('employee/create', [EmployeeController::class, 'store']);
    Route::put('employee/update/{id}', [EmployeeController::class, 'update']);
    Route::delete('employee/destroy/{id}', [EmployeeController::class, 'destroy']);
    Route::put('employee/updateStatus/{id}', [EmployeeController::class, 'updateStatus']);

    //Customer Section
    Route::get('customer', [CustomerController::class, 'index']);

    //Product Section
    Route::get('product', [ProductController::class, 'index']);
    Route::post('product/create', [ProductController::class, 'store']);
    Route::put('product/update/{id}', [ProductController::class, 'update']);
    Route::delete('product/destroy/{id}', [ProductController::class, 'destroy']);
    Route::put('product/updateStatus/{id}', [ProductController::class, 'updateStatus']);

    //Variation section
    Route::get('variation', [VariationController::class, 'index']);
    Route::post('variation/create', [VariationController::class, 'store']);
    Route::put('variation/update/{id}', [VariationController::class, 'update']);
    Route::delete('variation/destroy/{id}', [VariationController::class, 'destroy']);

    //Option section
    Route::get('option', [OptionController::class, 'index']);
    Route::post('option/create', [OptionController::class, 'store']);
    Route::put('option/update/{id}', [OptionController::class, 'update']);
    Route::delete('option/destroy/{id}', [OptionController::class, 'destroy']);

    //Oder section
    Route::get('order', [OrderController::class, 'index']);
    Route::get('order/{id}/details', [OrderController::class, 'getOrderDetails']);

    //Category Section
    Route::get('category', [CategoryController::class, 'index']);

    //Category
    Route::get('category', [CategoryController::class, 'index']);
    Route::post('category/create', [CategoryController::class, 'store']);
    Route::put('category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('category/destroy/{id}', [CategoryController::class, 'destroy']);

     //Payment
    Route::get('payment', [PaymentController::class, 'index']);
    Route::post('payment/create', [PaymentController::class, 'store']);
    Route::put('payment/update/{id}', [PaymentController::class, 'update']);
    Route::delete('payment/destroy/{id}', [PaymentController::class, 'destroy']);
});
