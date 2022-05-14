<?php

use App\Http\Controllers\API\productController;
use App\Http\Controllers\API\registerController;
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

Route::post('register', [registerController::class, 'register']);
Route::post('login', [registerController::class, 'login'] );

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', productController::class);
});