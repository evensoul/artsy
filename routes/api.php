<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controller;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', [Controller\CategoryController::class, 'list']);

Route::prefix('products')->group(function () {
    Route::get('/', [Controller\ProductController::class, 'list']);
    Route::get('vip', [Controller\ProductController::class, 'vip']);
    Route::get('recent-viewed', [Controller\ProductController::class, 'recentViewed']);
    Route::get('wish-list', [Controller\ProductController::class, 'wishList']);
    Route::get('my', [Controller\ProductController::class, 'my']);
    Route::get('{id}', [Controller\ProductController::class, 'show']);
});
