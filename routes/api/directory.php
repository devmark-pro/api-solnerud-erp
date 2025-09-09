<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\StatusPurchaseController;
use App\Http\Controllers\Directory\StatusSaleController;
use App\Http\Controllers\Directory\TypeFlowController;
use App\Http\Controllers\Directory\PaymentTypeController;
use App\Http\Controllers\Directory\EmployeePositionController;
use App\Http\Controllers\Directory\EmployeeStatusController;
use App\Http\Controllers\Directory\DeliveryMethodController;
use App\Http\Controllers\Directory\PackingTypeController;
use App\Http\Controllers\Directory\PositionRepresentativeController;
use App\Http\Controllers\Directory\CounterpartyTypeController;
use App\Http\Controllers\Directory\PurchaseTypeController;
use App\Http\Controllers\Directory\WarehouseController;
use App\Http\Controllers\Purchase\PurchaseDocumentController;


Route::prefix('status_purchase')->group(function () {
    Route::post('/', [StatusPurchaseController::class, 'index'] );
    Route::post('/create', [StatusPurchaseController::class, 'create'] ); 
    Route::post('/get', [StatusPurchaseController::class, 'card'] );
    Route::post('/update', [StatusPurchaseController::class, 'update'] );
    Route::post('/delete', [StatusPurchaseController::class, 'destroy'] );
    Route::post('/recover', [StatusPurchaseController::class, 'recover'] );
});

Route::prefix('status_sale')->group(function () {
    Route::post('/', [StatusSaleController::class, 'index'] );
    Route::post('/create', [StatusSaleController::class, 'create'] ); 
    Route::post('/get', [StatusSaleController::class, 'card'] );
    Route::post('/update', [StatusSaleController::class, 'update'] );
    Route::post('/delete', [StatusSaleController::class, 'destroy'] );
    Route::post('/recover', [StatusSaleController::class, 'recover'] );
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
    Route::post('/', [PaymentTypeController::class, 'index'] );
    Route::post('/create', [PaymentTypeController::class, 'create'] ); 
    Route::post('/get', [PaymentTypeController::class, 'card'] );
    Route::post('/update', [PaymentTypeController::class, 'update'] );
    Route::post('/delete', [PaymentTypeController::class, 'destroy'] );
    Route::post('/recover', [PaymentTypeController::class, 'recover'] );
});

Route::prefix('employee_position')->group(function () {
    Route::post('/', [EmployeePositionController::class, 'index'] );
    Route::post('/create', [EmployeePositionController::class, 'create'] ); 
    Route::post('/get', [EmployeePositionController::class, 'card'] );
    Route::post('/update', [EmployeePositionController::class, 'update'] );
    Route::post('/delete', [EmployeePositionController::class, 'destroy'] );
    Route::post('/recover', [EmployeePositionController::class, 'recover'] );
});

Route::prefix('employee_status')->group(function () {
    Route::post('/', [EmployeeStatusController::class, 'index'] );
    Route::post('/create', [EmployeeStatusController::class, 'create'] ); 
    Route::post('/get', [EmployeeStatusController::class, 'card'] );
    Route::post('/update', [EmployeeStatusController::class, 'update'] );
    Route::post('/delete', [EmployeeStatusController::class, 'destroy'] );
    Route::post('/recover', [EmployeeStatusController::class, 'recover'] );
});

Route::prefix('delivery_method')->group(function () {
    Route::post('/', [DeliveryMethodController::class, 'index'] );
    Route::post('/create', [DeliveryMethodController::class, 'create'] ); 
    Route::post('/get', [DeliveryMethodController::class, 'card'] );
    Route::post('/update', [DeliveryMethodController::class, 'update'] );
    Route::post('/delete', [DeliveryMethodController::class, 'destroy'] );
    Route::post('/recover', [DeliveryMethodController::class, 'recover'] );
});

Route::prefix('packing_type')->group(function () {
    Route::post('/', [PackingTypeController::class, 'index'] );
    Route::post('/create', [PackingTypeController::class, 'create'] ); 
    Route::post('/get', [PackingTypeController::class, 'card'] );
    Route::post('/update', [PackingTypeController::class, 'update'] );
    Route::post('/delete', [PackingTypeController::class, 'destroy'] );
    Route::post('/recover', [PackingTypeController::class, 'recover'] );
});

Route::prefix('position_representative')->group(function () {
    Route::post('/', [PositionRepresentativeController::class, 'index'] );
    Route::post('/create', [PositionRepresentativeController::class, 'create'] ); 
    Route::post('/get', [PositionRepresentativeController::class, 'card'] );
    Route::post('/update', [PositionRepresentativeController::class, 'update'] );
    Route::post('/delete', [PositionRepresentativeController::class, 'destroy'] );
    Route::post('/recover', [PositionRepresentativeController::class, 'recover'] );
});

Route::prefix('counterparty_type')->group(function () {
    Route::post('/', [CounterpartyTypeController::class, 'index'] );
    Route::post('/create', [CounterpartyTypeController::class, 'create'] ); 
    Route::post('/get', [CounterpartyTypeController::class, 'card'] );
    Route::post('/update', [CounterpartyTypeController::class, 'update'] );
    Route::post('/delete', [CounterpartyTypeController::class, 'destroy'] );
    Route::post('/recover', [CounterpartyTypeController::class, 'recover'] );
});

Route::prefix('purchase_type')->group(function () {
    Route::post('/', [PurchaseTypeController::class, 'index'] );
    Route::post('/create', [PurchaseTypeController::class, 'create'] ); 
    Route::post('/get', [PurchaseTypeController::class, 'card'] );
    Route::post('/update', [PurchaseTypeController::class, 'update'] );
    Route::post('/delete', [PurchaseTypeController::class, 'destroy'] );
    Route::post('/recover', [PurchaseTypeController::class, 'recover'] );
});

Route::prefix('warehouse')->group(function () {
    Route::post('/', [WarehouseController::class, 'index'] );
    Route::post('/create', [WarehouseController::class, 'create'] ); 
    Route::post('/get', [WarehouseController::class, 'card'] );
    Route::post('/update', [WarehouseController::class, 'update'] );
    Route::post('/delete', [WarehouseController::class, 'destroy'] );
    Route::post('/recover', [WarehouseController::class, 'recover'] );
});

Route::prefix('purchase_document')->group(function () {
    Route::post('/', [PurchaseDocumentController::class, 'index'] );
    Route::post('/create', [PurchaseDocumentController::class, 'create'] ); 
    Route::post('/get', [PurchaseDocumentController::class, 'card'] );
    Route::post('/update', [PurchaseDocumentController::class, 'update'] );
    Route::post('/delete', [PurchaseDocumentController::class, 'destroy'] );
    Route::post('/recover', [PurchaseDocumentController::class, 'recover'] );
});
