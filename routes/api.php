<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/sales', [\App\Http\Controllers\SaleController::class, 'store']);
Route::get('/sales/{uuid}', [\App\Http\Controllers\SaleController::class, 'show']);
Route::get('/sales', [\App\Http\Controllers\SaleController::class, 'index']);
Route::delete('/sales/{uuid}', [\App\Http\Controllers\SaleController::class, 'cancel']);

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index']);

