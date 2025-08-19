<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\StatusPurchaseController;
use App\Http\Controllers\Directory\StatusSaleController;
use App\Http\Controllers\Directory\TypeFlowController;
use App\Http\Controllers\Directory\PaymentTypeController;
use App\Http\Controllers\Directory\EmployeePositionsController;
use App\Http\Controllers\Directory\EmployeeStatusController;
use App\Http\Controllers\Directory\DeliveryMethodController;
use App\Http\Controllers\Directory\PackingTypeController;
use App\Http\Controllers\Directory\PositionRepresentativeController;
use App\Http\Controllers\Directory\CounterpartyTypeController;
use App\Http\Controllers\Directory\PurchaseTypeController;
use App\Http\Controllers\CounterpartyController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PurchaseController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('status_purchase')->group(function () {
    Route::get('/', [StatusPurchaseController::class, 'index'] );
    Route::put('/', [StatusPurchaseController::class, 'create'] ); 
    Route::get('/{id}', [StatusPurchaseController::class, 'card'] );
    Route::post('/{id}', [StatusPurchaseController::class, 'update'] );
    Route::delete('/{id}', [StatusPurchaseController::class, 'destroy'] );
    Route::get('/{id}/recover', [StatusPurchaseController::class, 'recover'] );
});

Route::prefix('status_sale')->group(function () {
    Route::get('/', [StatusSaleController::class, 'index'] );
    Route::put('/', [StatusSaleController::class, 'create'] ); 
    Route::get('/{id}', [StatusSaleController::class, 'card'] );
    Route::post('/{id}', [StatusSaleController::class, 'update'] );
    Route::delete('/{id}', [StatusSaleController::class, 'destroy'] );
    Route::get('/{id}/recover', [StatusSaleController::class, 'recover'] );
});

Route::prefix('type_flow')->group(function () {
    Route::get('/', [TypeFlowController::class, 'index'] );
    Route::put('/', [TypeFlowController::class, 'create'] ); 
    Route::get('/{id}', [TypeFlowController::class, 'card'] );
    Route::post('/{id}', [TypeFlowController::class, 'update'] );
    Route::delete('/{id}', [TypeFlowController::class, 'destroy'] );
    Route::get('/{id}/recover', [TypeFlowController::class, 'recover'] );
});

Route::prefix('payment_type')->group(function () {
    Route::get('/', [PaymentTypeController::class, 'index'] );
    Route::put('/', [PaymentTypeController::class, 'create'] ); 
    Route::get('/{id}', [PaymentTypeController::class, 'card'] );
    Route::post('/{id}', [PaymentTypeController::class, 'update'] );
    Route::delete('/{id}', [PaymentTypeController::class, 'destroy'] );
    Route::get('/{id}/recover', [PaymentTypeController::class, 'recover'] );
});

Route::prefix('employee_position')->group(function () {
    Route::get('/', [EmployeePositionsController::class, 'index'] );
    Route::put('/', [EmployeePositionsController::class, 'create'] ); 
    Route::get('/{id}', [EmployeePositionsController::class, 'card'] );
    Route::post('/{id}', [EmployeePositionsController::class, 'update'] );
    Route::delete('/{id}', [EmployeePositionsController::class, 'destroy'] );
    Route::get('/{id}/recover', [EmployeePositionsController::class, 'recover'] );
});

Route::prefix('employee_status')->group(function () {
    Route::get('/', [EmployeeStatusController::class, 'index'] );
    Route::put('/', [EmployeeStatusController::class, 'create'] ); 
    Route::get('/{id}', [EmployeeStatusController::class, 'card'] );
    Route::post('/{id}', [EmployeeStatusController::class, 'update'] );
    Route::delete('/{id}', [EmployeeStatusController::class, 'destroy'] );
    Route::get('/{id}/recover', [EmployeeStatusController::class, 'recover'] );
});

Route::prefix('delivery_method')->group(function () {
    Route::get('/', [DeliveryMethodController::class, 'index'] );
    Route::put('/', [DeliveryMethodController::class, 'create'] ); 
    Route::get('/{id}', [DeliveryMethodController::class, 'card'] );
    Route::post('/{id}', [DeliveryMethodController::class, 'update'] );
    Route::delete('/{id}', [DeliveryMethodController::class, 'destroy'] );
    Route::get('/{id}/recover', [DeliveryMethodController::class, 'recover'] );
});

Route::prefix('packing_type')->group(function () {
    Route::get('/', [PackingTypeController::class, 'index'] );
    Route::put('/', [PackingTypeController::class, 'create'] ); 
    Route::get('/{id}', [PackingTypeController::class, 'card'] );
    Route::post('/{id}', [PackingTypeController::class, 'update'] );
    Route::delete('/{id}', [PackingTypeController::class, 'destroy'] );
    Route::get('/{id}/recover', [PackingTypeController::class, 'recover'] );
});

Route::prefix('position_representative')->group(function () {
    Route::get('/', [PositionRepresentativeController::class, 'index'] );
    Route::put('/', [PositionRepresentativeController::class, 'create'] ); 
    Route::get('/{id}', [PositionRepresentativeController::class, 'card'] );
    Route::post('/{id}', [PositionRepresentativeController::class, 'update'] );
    Route::delete('/{id}', [PositionRepresentativeController::class, 'destroy'] );
    Route::get('/{id}/recover', [PositionRepresentativeController::class, 'recover'] );
});

Route::prefix('counterparty_type')->group(function () {
    Route::get('/', [CounterpartyTypeController::class, 'index'] );
    Route::put('/', [CounterpartyTypeController::class, 'create'] ); 
    Route::get('/{id}', [CounterpartyTypeController::class, 'card'] );
    Route::post('/{id}', [CounterpartyTypeController::class, 'update'] );
    Route::delete('/{id}', [CounterpartyTypeController::class, 'destroy'] );
    Route::get('/{id}/recover', [CounterpartyTypeController::class, 'recover'] );
});

Route::prefix('purchase_type')->group(function () {
    Route::get('/', [PurchaseTypeController::class, 'index'] );
    Route::put('/', [PurchaseTypeController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseTypeController::class, 'card'] );
    Route::post('/{id}', [PurchaseTypeController::class, 'update'] );
    Route::delete('/{id}', [PurchaseTypeController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseTypeController::class, 'recover'] );
});

Route::prefix('counterparties')->group(function () {
    Route::get('/', [CounterpartyController::class, 'index'] );
    Route::put('/', [CounterpartyController::class, 'create'] ); 
    Route::get('/{id}', [CounterpartyController::class, 'card'] );
    Route::post('/{id}', [CounterpartyController::class, 'update'] );
    Route::delete('/{id}', [CounterpartyController::class, 'destroy'] );
    Route::get('/{id}/recover', [CounterpartyController::class, 'recover'] );
});


Route::prefix('nomenclature')->group(function () {
    Route::get('/', [NomenclatureController::class, 'index'] );
    Route::put('/', [NomenclatureController::class, 'create'] ); 
    Route::get('/{id}', [NomenclatureController::class, 'card'] );
    Route::post('/{id}', [NomenclatureController::class, 'update'] );
    Route::delete('/{id}', [NomenclatureController::class, 'destroy'] );
    Route::get('/{id}/recover', [NomenclatureController::class, 'recover'] );
});


Route::prefix('client')->group(function () {
    Route::get('/', [ClientController::class, 'index'] );
    Route::put('/', [ClientController::class, 'create'] ); 
    Route::get('/{id}', [ClientController::class, 'card'] );
    Route::post('/{id}', [ClientController::class, 'update'] );
    Route::delete('/{id}', [ClientController::class, 'destroy'] );
    Route::get('/{id}/recover', [ClientController::class, 'recover'] );
});

Route::prefix('purchase')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'] );
    Route::put('/', [PurchaseController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseController::class, 'card'] );
    Route::post('/{id}', [PurchaseController::class, 'update'] );
    Route::delete('/{id}', [PurchaseController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseController::class, 'recover'] );
});
