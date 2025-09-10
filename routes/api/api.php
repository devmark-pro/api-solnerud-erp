<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CounterpartyController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Purchase\PurchaseDeliveryAddressController;
use App\Http\Controllers\Purchase\PurchaseInvoiceController;
use App\Http\Controllers\Purchase\PurchaseAccountSupplierController;
use App\Http\Controllers\Purchase\PurchaseReceiptsController;
use App\Http\Controllers\Purchase\PurchaseExpenseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('counterparties')->group(function () {
    Route::post('/', [CounterpartyController::class, 'index'] );
    Route::post('/create', [CounterpartyController::class, 'create'] ); 
    Route::post('/get', [CounterpartyController::class, 'card'] );
    Route::post('/{id}', [CounterpartyController::class, 'update'] );
    Route::post('/delete', [CounterpartyController::class, 'destroy'] );
    Route::post('/recover', [CounterpartyController::class, 'recover'] );
});

Route::prefix('nomenclature')->group(function () {
    Route::post('/', [NomenclatureController::class, 'index'] );
    Route::post('/create', [NomenclatureController::class, 'create'] ); 
    Route::post('/get', [NomenclatureController::class, 'card'] );
    Route::post('/{id}', [NomenclatureController::class, 'update'] );
    Route::post('/delete', [NomenclatureController::class, 'destroy'] );
    Route::post('/recover', [NomenclatureController::class, 'recover'] );
});

Route::prefix('client')->group(function () {
    Route::post('/', [ClientController::class, 'index'] );
    Route::post('/create', [ClientController::class, 'create'] ); 
    Route::post('/get', [ClientController::class, 'card'] );
    Route::post('/{id}', [ClientController::class, 'update'] );
    Route::post('/delete', [ClientController::class, 'destroy'] );
    Route::post('/recover', [ClientController::class, 'recover'] );
});


Route::prefix('user')->group(function () {
    Route::post('/', [UserController::class, 'index'] );
    Route::post('/create', [UserController::class, 'create'] ); 
    Route::post('/get', [UserController::class, 'card'] );
    Route::post('/{id}', [UserController::class, 'update'] );
    Route::post('/delete', [UserController::class, 'destroy'] );
    Route::post('/recover', [UserController::class, 'recover'] );
});

Route::prefix('purchase')->group(function () {
    Route::post('/', [PurchaseController::class, 'index'] );
    Route::post('/create', [PurchaseController::class, 'create'] ); 
    Route::post('/get', [PurchaseController::class, 'card'] );
    Route::post('/{id}', [PurchaseController::class, 'update'] );
    Route::post('/delete', [PurchaseController::class, 'destroy'] );
    Route::post('/recover', [PurchaseController::class, 'recover'] );
});

Route::prefix('purchase_delivery_address')->group(function () {
    Route::post('/', [PurchaseDeliveryAddressController::class, 'index'] );
    Route::post('/create', [PurchaseDeliveryAddressController::class, 'create'] ); 
    Route::post('/get', [PurchaseDeliveryAddressController::class, 'card'] );
    Route::post('/{id}', [PurchaseDeliveryAddressController::class, 'update'] );
    Route::post('/delete', [PurchaseDeliveryAddressController::class, 'destroy'] );
    Route::post('/recover', [PurchaseDeliveryAddressController::class, 'recover'] );
});

Route::prefix('purchase_invoice')->group(function () {
    Route::post('/', [PurchaseInvoiceController::class, 'index'] );
    Route::post('/create', [PurchaseInvoiceController::class, 'create'] ); 
    Route::post('/get', [PurchaseInvoiceController::class, 'card'] );
    Route::post('/{id}', [PurchaseInvoiceController::class, 'update'] );
    Route::post('/delete', [PurchaseInvoiceController::class, 'destroy'] );
    Route::post('/recover', [PurchaseInvoiceController::class, 'recover'] );
});

Route::prefix('purchase_account_supplier')->group(function () {
    Route::post('/', [PurchaseAccountSupplierController::class, 'index'] );
    Route::post('/create', [PurchaseAccountSupplierController::class, 'create'] ); 
    Route::post('/get', [PurchaseAccountSupplierController::class, 'card'] );
    Route::post('/{id}', [PurchaseAccountSupplierController::class, 'update'] );
    Route::post('/delete', [PurchaseAccountSupplierController::class, 'destroy'] );
    Route::post('/recover', [PurchaseAccountSupplierController::class, 'recover'] );
});

Route::prefix('purchase_receipts')->group(function () {
    Route::post('/', [PurchaseReceiptsController::class, 'index'] );
    Route::post('/create', [PurchaseReceiptsController::class, 'create'] ); 
    Route::post('/get', [PurchaseReceiptsController::class, 'card'] );
    Route::post('/{id}', [PurchaseReceiptsController::class, 'update'] );
    Route::post('/delete', [PurchaseReceiptsController::class, 'destroy'] );
    Route::post('/recover', [PurchaseReceiptsController::class, 'recover'] );
});

Route::prefix('purchase_expenses')->group(function () {
    Route::post('/', [PurchaseExpenseController::class, 'index'] );
    Route::post('/create', [PurchaseExpenseController::class, 'create'] ); 
    Route::post('/get', [PurchaseExpenseController::class, 'card'] );
    Route::post('/{id}', [PurchaseExpenseController::class, 'update'] );
    Route::post('/delete', [PurchaseExpenseController::class, 'destroy'] );
    Route::post('/recover', [PurchaseExpenseController::class, 'recover'] );
});