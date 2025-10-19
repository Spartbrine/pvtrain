<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('auth/register', [App\Http\Controllers\AuthController::class, 'register']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('branch', 'App\Http\Controllers\BranchController');
    Route::apiResource('customer', 'App\Http\Controllers\CustomerController');
    Route::apiResource('product', 'App\Http\Controllers\ProductController');
    Route::apiResource('categories', 'App\Http\Controllers\CategoryController');
});

Route::apiResource('entrie', 'App\Http\Controllers\EntrieController');
Route::apiResource('provider', 'App\Http\Controllers\ProviderController');
Route::apiResource('sale', 'App\Http\Controllers\SaleController');
Route::apiResource('saleitem', 'App\Http\Controllers\SaleItemController');


