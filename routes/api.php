<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Auth\UserDetailsController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->put('auth/user/details', [UserDetailsController::class, 'update']);
Route::middleware('auth:api')->get('auth/user/show', [UserController::class, 'show']);


Route::get('auth/check-email-verification', [AuthController::class, 'checkEmailVerification']);

Route::get('products', [ProductController::class, 'products']);
Route::get('categories/{categoryId}/products', [ProductController::class, 'getProductsByCategory']);
Route::get('products/{id}', [ProductController::class, 'getProductsById']);
Route::get('products/{productId}/comments', [CommentController::class, 'getCommentByProductId']);
Route::get('products/search', [ProductController::class, 'search']);

Route::get('categories', [CategoryController::class, 'categories']);

Route::get('brand', [BrandController::class, 'brand']);

Route::post('cart/add', [CartController::class, 'addToCart'])->middleware('auth:api');
Route::post('cart/removeFromCart', [CartController::class, 'removeFromCart'])->middleware('auth:api');
Route::get('cart/itemcount', [CartController::class, 'getItemCount'])->middleware('auth:api');
Route::get('cart/showCartByUser', [CartController::class, 'showCartByUser'])->middleware('auth:api');