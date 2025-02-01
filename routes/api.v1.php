<?php

use App\Http\Controllers\AdminNoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerNumberController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClearanceRateController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DamageClaimController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportRateController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\ShippingRateController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TitleTypeController;
use App\Http\Controllers\TowingRateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VccController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::get('invoice/payment-receipt', [VoucherController::class, 'invoicePaymentReceipt']);
Route::get('advanced-account-receipt/print-pdf/{id}', [VoucherController::class, 'advancedPaymentReceipt']);

/* public api for website */
Route::group(['prefix' => 'public'], function () {
    Route::post('contact-us', [ContactMessageController::class, 'store']);
    Route::get('search/countries', [SearchController::class, 'searchCountry']);
    Route::post('get-export-price', [ExportRateController::class, 'searchPrice']);
    Route::get('search/cities', [PricingController::class, 'searchCitiesWithState']);
    Route::get('search/ports', [SearchController::class, 'searchPort']);
    Route::post('get-import-price', [PricingController::class, 'searchPrice']);
});
/* public api for website */

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    /* Dashboard related routes */
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('dashboard-mobile', [DashboardController::class, 'dashboardMobileApi']);
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

    Route::post('users/upload-profile-photo', [UserController::class, 'uploadProfilePhoto']);
    Route::post('users/{id}/change-status', [UserController::class, 'changeStatus']);
    Route::put('users/{id}/permissions', [UserController::class, 'updatePermissions']);
    Route::get('users/{id}/permissions', [UserController::class, 'permissions']);
    Route::get('users/export-excel', [UserController::class, 'exportExcel']);
    Route::apiResource('users', UserController::class);

    Route::apiResource('roles', RoleController::class)->except('store', 'destroy');

    Route::get('sheets/export-excel', [SheetController::class, 'exportExcel']);
    Route::apiResource('sheets', SheetController::class);
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
    Route::post('contact-us', [CustomerController::class, 'contactMessage']);
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
    Route::get('vehicles/search-by-vin', [VehicleController::class, 'getByVin']);
    Route::get('vehicles/{id}/all-photos', [VehicleController::class, 'allPhotos']);
    Route::post('vehicles/{id}/add-more-photos', [VehicleController::class, 'addMorePhotos']);
    Route::get('vehicles/{id}/download-photos', [VehicleController::class, 'downloadVehiclePhotos']);
    Route::get('vehicles/{id}/download-document', [VehicleController::class, 'downloadVehicleDocuments']);
    Route::post('vehicles/upload-document', [VehicleController::class, 'uploadDocument']);
    Route::post('vehicles/upload-photo', [VehicleController::class, 'uploadPhoto']);
    Route::get('vehicles/export-excel', [VehicleController::class, 'exportExcel']);
    Route::post('vehicles/{id}/change-note-status', [VehicleController::class, 'changeNoteStatus']);
    Route::apiResource('vehicles', VehicleController::class);
    /* vehicles related endpoints */

    /* containers related endpoints */
    Route::get('containers/{id}/all-photos', [ContainerController::class, 'allPhotos']);
    Route::post('containers/{id}/add-more-photos', [ContainerController::class, 'addMorePhotos']);
    Route::get('containers/{id}/download-photos', [ContainerController::class, 'downloadPhotos']);
    Route::get('containers/{id}/download-document', [ContainerController::class, 'downloadDocuments']);
    Route::post('containers/upload-document', [ContainerController::class, 'uploadDocument']);
    Route::post('containers/upload-photo', [ContainerController::class, 'uploadPhoto']);
    Route::get('container/export-excel', [ContainerController::class, 'exportExcel']);
    Route::post('containers/{id}/change-note-status', [ContainerController::class, 'changeNoteStatus']);
    Route::apiResource('containers', ContainerController::class);
    /* containers related endpoints */

    /* damage claim related endpoints */
    Route::get('damage-claims/{id}/print-voucher-pdf', [DamageClaimController::class, 'printAsPdfVoucher']);
    Route::put('damage-claims/{id}/approve', [DamageClaimController::class, 'damageClaimApprove']);
    Route::put('damage-claims/{id}/reject', [DamageClaimController::class, 'damageClaimReject']);
    Route::get('damage-claims/{id}/download-photos', [DamageClaimController::class, 'downloadDamageClaimPhotos']);
    Route::post('damage-claims/upload-photo', [DamageClaimController::class, 'uploadPhoto']);
    Route::get('damage-claims/export-excel', [DamageClaimController::class, 'exportExcel']);
    Route::apiResource('damage-claims', DamageClaimController::class);
    /* damage claim related endpoints */

    /* vcc related endpoints */
    Route::post('vcc/{id}/hand-over', [VccController::class, 'vccHandOver']);
    Route::get('vcc-reset/{id}', [VccController::class, 'VccReset']);
    Route::post('vcc/upload-attachment', [VccController::class, 'uploadVccAttachment']);
    Route::post('vcc/{id}/store-attachment', [VccController::class, 'storeVccAttachment']);
    Route::get('vcc/{id}/get-detail-form', [VccController::class, 'getVccDetail']);
    Route::post('vcc/{id}/store-vcc-detail', [VccController::class, 'storeVccDetail']);
    Route::get('vcc/export-excel', [VccController::class, 'exportExcel']);
    Route::post('vcc/{id}/received-exit-paper', [VccController::class, 'storeReceivedExitPaper']);
    Route::post('vcc/{id}/submit-exit-paper', [VccController::class, 'storeSubmitExitPaper']);
    Route::apiResource('vccs', VccController::class);
    /* vcc related endpoints */

    /* note related endpoints */
    Route::post('vcc/{id}/store-vcc-note', [AdminNoteController::class, 'storeVccNote']);
    Route::post('vcc/{id}/store-submission-note', [AdminNoteController::class, 'storeSubmissionVcc']);
    Route::get('vcc/{id}/get-vcc-note', [AdminNoteController::class, 'getVccNote']);
    Route::get('vcc/{id}/get-submission-note', [AdminNoteController::class, 'getSubmissionNote']);
    Route::post('vehicle/{id}/note', [AdminNoteController::class, 'storeVehicleNote']);
    Route::get('vehicle/{id}/note', [AdminNoteController::class, 'getVehicleNote']);
    Route::post('container/{id}/note', [AdminNoteController::class, 'storeContainerNote']);
    Route::get('container/{id}/note', [AdminNoteController::class, 'getContainerNote']);

    Route::post('container/{id}/store-note', [NoteController::class, 'containerStoreNote']);
    Route::get('container/{id}/get-note', [NoteController::class, 'containerGetNote']);
    Route::post('vehicle/{id}/store-note', [NoteController::class, 'vehicleStoreNote']);
    Route::get('vehicle/{id}/get-note', [NoteController::class, 'vehicleGetNote']);
    /* note related endpoints */

    /* buyer number related endpoints */
    Route::get('/customer-buyer-numbers', [BuyerNumberController::class, 'customerBuyerNumber']);
    Route::put('buyer-number/add-customer', [BuyerNumberController::class, 'submitAddCustomer']);
    Route::put('buyer-number/replace-customer', [BuyerNumberController::class, 'submitReplaceCustomer']);
    Route::post('buyer-number/upload-attachment', [BuyerNumberController::class, 'BuyerNumberAttachment']);
    Route::get('buyer-numbers/export-excel', [BuyerNumberController::class, 'exportExcel']);
    Route::get('buyer-number/{id}', [BuyerNumberController::class, 'sheetWiseBuyerNumber']);
    Route::apiResource('buyer-numbers', BuyerNumberController::class);
    /* buyer number related endpoints */

    /* complain and conversations related endpoints */
    Route::post('complains/store-conversation', [ComplainController::class, 'storeConversation']);
    Route::apiResource('complains', ComplainController::class);
    /* complain and conversations related endpoints */

    /* invoice related endpoints */
    Route::get('vehicle-accounting-invoice', [InvoiceController::class, 'vehicleAccountingInvoice']);
    Route::get('shipping-accounting-invoice', [InvoiceController::class, 'serviceAccountingInvoice']);
    Route::get('invoice-summary', [InvoiceController::class, 'invoiceSummary']);
    Route::get('customer-statement', [InvoiceController::class, 'customerInvoicePdf']);
    /* invoice related endpoints */

    /* pricing related endpoints */
    Route::get('shipping-vehicle-pdf-generate', [PricingController::class, 'shippingPricePdfGenerate']);
    Route::get('shipping-price-per-vehicle', [PricingController::class, 'pricingPerVehicle']);
    Route::get('pricing-import', [PricingController::class, 'index']);
    Route::get('pricing-export', [PricingController::class, 'exportPricing']);
    Route::delete('pricing/{id}', [PricingController::class, 'destroy']);

    Route::get('generate-export-pricing', [ExportRateController::class, 'generatePricing']);
    Route::get('export-rates/export-excel', [ExportRateController::class, 'exportExcel']);
    Route::apiResource('export-rates', ExportRateController::class);
    /* pricing related endpoints */


    /* voucher related endpoints */
    Route::post('approve-reject/voucher/{id}', [VoucherController::class, 'rejectApproveVoucher']);
    Route::post('pending-vouchers/{id}', [VoucherController::class, 'voucherDetail']);
    Route::get('pending-vouchers', [VoucherController::class, 'index']);
    Route::get('customer-advance-vouchers', [VoucherController::class, 'advancedVoucher']);
    Route::get('customer-invoice-vouchers', [VoucherController::class, 'invoiceVoucher']);
    Route::get('payment-modes', [VoucherController::class, 'getPaymentModes']);
    /* voucher related endpoints */

    Route::get('localization', function () {
        return response()->json(config('setting.mobile_languages'));
    });

    Route::apiResource('notes', NoteController::class)->only('store', 'index');

    Route::prefix('search')->controller(SearchController::class)
        ->group(function (): void {
            Route::get('countries', 'searchCountry');
            Route::get('states', 'searchState');
            Route::get('cities', 'searchCity');
            Route::get('locations', 'searchLocation');
            Route::get('ports', 'searchPort');
            Route::get('roles', 'searchRole');
            Route::get('customers', 'searchCustomer');
            Route::get('customers/{id}/buyer-numbers', 'searchBuyerNumbers');
            Route::get('title-types', 'searchTitleTypes');
            Route::get('colors', 'searchColor');
            Route::get('conditions', 'searchVehicleCondition');
            Route::get('features', 'searchVehicleFeature');
            Route::get('vehicles', 'searchVehicle');
            Route::get('consignees', 'searchConsignee');
            Route::get('master-account', 'searchMasterAccount');
        });
});
