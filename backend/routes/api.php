<?php

use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SquadController;
use App\Http\Controllers\SquadPeriodController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [UserController::class, 'login']);
    });

    Route::apiResource('squads', SquadController::class);
    Route::apiResource('periods', PeriodController::class);
    Route::apiResource('squad-periods', SquadPeriodController::class);
});
