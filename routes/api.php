<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controller;
use Laravel\Socialite\Facades\Socialite;

Route::get('categories-tree', [Controller\CategoryController::class, 'tree']);
Route::get('categories/{category}', [Controller\CategoryController::class, 'show']);

Route::get('attributes', [Controller\AttributeController::class, 'list']);

Route::prefix('products')->group(function () {
    Route::get('/', [Controller\ProductController::class, 'list']);
    Route::get('search', [Controller\ProductController::class, 'search']);
    Route::get('vip', [Controller\ProductController::class, 'vip']);
    Route::get('recent-viewed', [Controller\ProductController::class, 'recentViewed']);
    Route::post('/', [Controller\ProductController::class, 'create'])->middleware('auth:sanctum');
    Route::get('my', [Controller\ProductController::class, 'my'])->middleware('auth:sanctum');
    Route::get('my/{id}', [Controller\ProductController::class, 'showMy'])->middleware('auth:sanctum');

    Route::get('wish-list', [Controller\WishListController::class, 'list'])->middleware('auth:sanctum');
    Route::post('/{product}/wish-list', [Controller\WishListController::class, 'addProduct'])->middleware('auth:sanctum');
    Route::delete('/{product}/wish-list', [Controller\WishListController::class, 'removeProduct'])->middleware('auth:sanctum');

    Route::get('/{product}/reviews', [Controller\ProductReviewController::class, 'list']);
    Route::post('/{product}/reviews', [Controller\ProductReviewController::class, 'create'])->middleware('auth:sanctum');

    Route::get('{id}', [Controller\ProductController::class, 'show']);
});

Route::post('auth/register', [Controller\AuthController::class, 'register']);
Route::post('auth/login', [Controller\AuthController::class, 'login']);
Route::post('auth/refresh', [Controller\AuthController::class, 'refresh'])->middleware('auth:sanctum');
Route::get('auth/me', [Controller\AuthController::class, 'profile'])->middleware('auth:sanctum');

Route::get('customers/popular', [Controller\CustomerController::class, 'listPopular']);
Route::get('customers/{customer}', [Controller\CustomerController::class, 'show']);
Route::patch('customers/{customer}', [Controller\CustomerController::class, 'update'])->middleware('auth:sanctum');

Route::get('banners', [Controller\BannerController::class, 'list']);







Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->stateless()->redirect();

});

Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});
