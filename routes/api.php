<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BestSellingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExclusiveOfferController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PanerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::post('verify-otp','verifyOtp');
    Route::post('logout','logout')->middleware('auth:sanctum');
    Route::post('reset-password','resetPassword');
})->middleware('SetLocale');

Route::apiResources([
    'categories' => CategoryController::class,
    'sub-categories' => SubCategoryController::class,
    'brands' => BrandController::class,
    'products' => ProductController::class,
    'paners' => PanerController::class,
    'offers' => ExclusiveOfferController::class,
    'best-selling' => BestSellingController::class,
    'carts' => CartController::class
]);

Route::controller(FavoriteController::class)->group(function(){
    Route::prefix('favorites')->group(function(){
        Route::get('','index'); //all favorites
        Route::get('/user/{user_id}','userFavorites');  //user favorites
        Route::post('','store'); 
        Route::delete('/{product_id}','destroy');
    });
});

Route::controller(ReviewController::class)->group(function(){
    Route::prefix('reviews')->group(function(){
        Route::get('','index'); //all reviews
        Route::get('/user/{user_id}','userReviews');  //user reviews
        Route::get('/product/{product_id}','productReviews');  //product reviews
        Route::post('','store'); 
        Route::delete('/{product_id}','destroy');
    });
});


