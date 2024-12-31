<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClearanceRateController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShippingRateController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TitleTypeController;
use App\Http\Controllers\TowingRateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    /* Dashboard related routes */
    Route::get('status-overview', [DashboardController::class, 'statusOverview']);
    Route::get('monthly-sales', [DashboardController::class, 'monthlySales']);
    /* Dashboard related routes */

    /* setting related endpoints */
    Route::get('countries/export-excel', [CountryController::class, 'exportExcel']);
    Route::apiResource('countries', CountryController::class);

    Route::get('states/export-excel', [StateController::class, 'exportExcel']);
    Route::apiResource('states', StateController::class);

    Route::get('cities/export-excel', [CityController::class, 'exportExcel']);
    Route::apiResource('cities', CityController::class);

    Route::get('locations/export-excel', [LocationController::class, 'exportExcel']);
    Route::apiResource('locations', LocationController::class);

    Route::get('ports/export-excel', [PortController::class, 'exportExcel']);
    Route::apiResource('ports', PortController::class);

    Route::get('title-types/export-excel', [TitleTypeController::class, 'exportExcel']);
    Route::apiResource('title-types', TitleTypeController::class);

    Route::post('users/{id}/change-status', [UserController::class, 'changeStatus']);
    Route::put('users/{id}/permissions', [UserController::class, 'updatePermissions']);
    Route::get('users/{id}/permissions', [UserController::class, 'permissions']);
    Route::get('users/export-excel', [UserController::class, 'exportExcel']);
    Route::apiResource('users', UserController::class);

    Route::apiResource('roles', RoleController::class)->except('store', 'destroy');
    /* setting related endpoints */

    /* notification related endpoints */
    Route::apiResource('notifications', NotificationController::class);
    /* notification related endpoints */

    /* customer related endpoints */
    Route::get('customers/next-customer-id', [CustomerController::class, 'nextCustomerId']);
    Route::get('customers/export-excel', [CustomerController::class, 'exportExcel']);
    Route::post('customers/upload-document', [CustomerController::class, 'uploadDocument']);
    Route::post('customers/upload-profile-photo', [CustomerController::class, 'uploadProfilePhoto']);
    Route::apiResource('customers', CustomerController::class);
    /* customer related endpoints */

    /* consignee related endpoints */
    Route::get('consignees/export-excel', [ConsigneeController::class, 'exportExcel']);
    Route::apiResource('consignees', ConsigneeController::class);
    /* consignee related endpoints */

    /* pricing related endpoints */
    Route::get('towing-rates/export-excel', [TowingRateController::class, 'exportExcel']);
    Route::apiResource('towing-rates', TowingRateController::class);

    Route::get('shipping-rates/export-excel', [ShippingRateController::class, 'exportExcel']);
    Route::apiResource('shipping-rates', ShippingRateController::class);

    Route::apiResource('clearance-rates', ClearanceRateController::class)->only('index', 'store');
    /* pricing related endpoints */

    /* vehicles related endpoints */
    Route::get('vehicles/{id}/all-photos', [VehicleController::class, 'allPhotos']);
    Route::post('vehicles/{id}/add-more-photos', [VehicleController::class, 'addMorePhotos']);
    Route::get('vehicles/{id}/download-photos', [VehicleController::class, 'downloadVehiclePhotos']);
    Route::get('vehicles/{id}/download-document', [VehicleController::class, 'downloadVehicleDocuments']);
    Route::post('vehicles/upload-document', [VehicleController::class, 'uploadDocument']);
    Route::post('vehicles/upload-photo', [VehicleController::class, 'uploadPhoto']);
    Route::get('vehicle/export-excel', [VehicleController::class, 'exportExcel']);
    Route::apiResource('vehicles', VehicleController::class);
    /* vehicles related endpoints */

    Route::prefix('search')->controller(SearchController::class)
        ->group(function (): void {
            Route::get('countries', 'searchCountry');
            Route::get('states', 'searchState');
            Route::get('cities', 'searchCity');
            Route::get('locations', 'searchLocation');
            Route::get('ports', 'searchPort');
            Route::get('roles', 'searchRole');
            Route::get('customers', 'searchCustomer');
            Route::get('title-types', 'searchTitleType');
        });
});
