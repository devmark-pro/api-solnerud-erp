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
use App\Http\Controllers\Directory\WarehouseController;
use App\Http\Controllers\Purchase\PurchaseDocumentController;


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
    Route::post('/', [TypeFlowController::class, 'index'] );
    Route::post('/create', [TypeFlowController::class, 'create'] ); 
    Route::post('/get', [TypeFlowController::class, 'card'] );
    Route::post('/update', [TypeFlowController::class, 'update'] );
    Route::post('/delete', [TypeFlowController::class, 'destroy'] );
    Route::post('/recover', [TypeFlowController::class, 'recover'] );
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

Route::prefix('warehouse')->group(function () {
    Route::get('/', [WarehouseController::class, 'index'] );
    Route::put('/', [WarehouseController::class, 'create'] ); 
    Route::get('/{id}', [WarehouseController::class, 'card'] );
    Route::post('/{id}', [WarehouseController::class, 'update'] );
    Route::delete('/{id}', [WarehouseController::class, 'destroy'] );
    Route::get('/{id}/recover', [WarehouseController::class, 'recover'] );
});

Route::prefix('purchase_document')->group(function () {
    Route::get('/', [PurchaseDocumentController::class, 'index'] );
    Route::put('/', [PurchaseDocumentController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseDocumentController::class, 'card'] );
    Route::post('/{id}', [PurchaseDocumentController::class, 'update'] );
    Route::delete('/{id}', [PurchaseDocumentController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseDocumentController::class, 'recover'] );
});
