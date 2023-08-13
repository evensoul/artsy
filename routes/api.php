<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controller;
use Laravel\Socialite\Facades\Socialite;

Route::get('categories-tree', [Controller\CategoryController::class, 'tree']);
Route::get('categories/{category}', [Controller\CategoryController::class, 'show']);
Route::get('categories/by-customer/{customer}', [Controller\CategoryController::class, 'listByCustomer']);

Route::get('attributes', [Controller\AttributeController::class, 'list']);

Route::prefix('products')->group(function () {
    Route::get('/', [Controller\ProductController::class, 'list']);
    Route::get('search', [Controller\ProductController::class, 'search']);
    Route::get('vip', [Controller\ProductController::class, 'vip']);
    Route::get('recent-viewed', [Controller\ProductController::class, 'recentViewed']);
    Route::post('/', [Controller\ProductController::class, 'create'])->middleware('auth:sanctum');

    Route::get('my', [Controller\MyProductController::class, 'list'])->middleware('auth:sanctum');
    Route::post('my/{product}/vip/{package}', [Controller\MyProductController::class, 'makeVIP'])->middleware('auth:sanctum');
    Route::get('my/{product}', [Controller\MyProductController::class, 'show'])->middleware('auth:sanctum');
    Route::patch('my/{product}', [Controller\MyProductController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('my/{product}', [Controller\MyProductController::class, 'delete'])->middleware('auth:sanctum');

    Route::get('wish-list', [Controller\WishListController::class, 'list'])->middleware('auth:sanctum');
    Route::post('/{product}/wish-list', [Controller\WishListController::class, 'addProduct'])->middleware('auth:sanctum');
    Route::delete('/{product}/wish-list', [Controller\WishListController::class, 'removeProduct'])->middleware('auth:sanctum');

    Route::get('/{product}/reviews', [Controller\ProductReviewController::class, 'list']);
    Route::post('/{product}/reviews', [Controller\ProductReviewController::class, 'create'])->middleware('auth:sanctum');

    Route::get('{id}', [Controller\ProductController::class, 'show']);
});

Route::get('my/payment-transactions', [Controller\PaymentTransactionController::class, 'getByCustomer']);

Route::get('reviews/by-customer/{customer}', [Controller\ProductReviewController::class, 'listByCustomer']);

Route::post('auth/register', [Controller\AuthController::class, 'register']);
Route::post('auth/login', [Controller\AuthController::class, 'login']);
Route::post('auth/logout', [Controller\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('auth/refresh', [Controller\AuthController::class, 'refresh'])->middleware('auth:sanctum');
Route::get('auth/me', [Controller\AuthController::class, 'profile'])->middleware('auth:sanctum');

Route::post('auth/forgot-password', [Controller\PasswordResetController::class, 'createPasswordResetToken']);
Route::post('auth/reset-password', [Controller\PasswordResetController::class, 'resetPassword']);

Route::get('customers/popular', [Controller\CustomerController::class, 'listPopular']);
Route::get('customers/{customer}', [Controller\CustomerController::class, 'show']);
Route::patch('customers/{customer}', [Controller\CustomerController::class, 'update'])->middleware('auth:sanctum');

Route::get('banners', [Controller\BannerController::class, 'list']);
Route::get('vip-packages', [Controller\VipPackageController::class, 'list']);
Route::get('about/faq', [Controller\StaticPageController::class, 'faq']);
Route::get('about/how-works', [Controller\StaticPageController::class, 'howWorks']);
Route::get('about/safe-shopping', [Controller\StaticPageController::class, 'safeShopping']);
Route::get('about/terms-of-use', [Controller\StaticPageController::class, 'termsOfUse']);
Route::get('about/confidentiality', [Controller\StaticPageController::class, 'confidentiality']);


Route::get('/auth/social', [Controller\OAuthController::class, 'getRedirectUrl']);
Route::get('/auth/social/callback', [Controller\OAuthController::class, 'authCallback']);
Route::get('/auth/social/attach-account', [Controller\OAuthController::class, 'attachSocial'])->middleware('auth:sanctum');
Route::get('/auth/social/detach-account', [Controller\OAuthController::class, 'detachSocial'])->middleware('auth:sanctum');
