<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories',  CategoriesController::class);
Route::apiResource('products',   ProductController::class);
Route::apiResource('stores', StoreController::class);
Route::apiResource('carts',  CartController::class);
Route::get('carts/products/{user_id}', [CartController::class, 'getCartItems'])->name('cart.products');
Route::delete('carts/{user_id}/{product_id}', [CartController::class, 'deleteProduct']);
Route::post('confirm_cart', [CartController::class, 'confirmOrder']);
Route::get('stores/{store}/products', [StoreController::class, 'products'])->name('stores.products');


