<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Auth::routes();

Route::group(['middleware' => 'auth',] , function () {

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']
    )->name('dashboard');

    Route::resource('stores', \App\Http\Controllers\StoreController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
});


