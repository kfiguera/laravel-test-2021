<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('signup', [AuthController::class, 'signUp']);
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('logout', [AuthController::class, 'logout'])
        ->middleware('auth:api');
});

// Products

// Index products
Route::get('products', [ProductController::class, 'index']);

Route::group(['prefix' => 'products', 'middleware' => 'auth:api'], function () {
    Route::get('{product}', [ProductController::class, 'show']);
    Route::post('', [ProductController::class, 'store']);
    Route::post('{product}/buy', [ProductController::class, 'buy']);
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth:api'], function () {
    Route::get('', [ProfileController::class, 'index']);
    Route::get('purchases', [ProfileController::class, 'purchases']);
    Route::get('products', [ProfileController::class, 'products']);
});
