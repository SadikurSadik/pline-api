<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    /* setting related endpoints */
    Route::get('countries/export-excel', [CountryController::class, 'exportExcel']);
    Route::apiResource('countries', CountryController::class);
    /* setting related endpoints */

    /* notification related endpoints */
    Route::apiResource('notifications', NotificationController::class);
    /* notification related endpoints */
});
