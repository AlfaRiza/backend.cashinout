<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\CashController;

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


// Auth::loginUsingId(1);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', MeController::class);

    Route::prefix('cash')->group(function () {
        Route::post('create', [CashController::class, 'store']);
        Route::get('/', [CashController::class, 'index']);
    });
});
