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


Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'] );
    Route::put('/', [UserController::class, 'create'] ); 
    Route::get('/{id}', [UserController::class, 'card'] );
    Route::post('/{id}', [UserController::class, 'update'] );
    Route::delete('/{id}', [UserController::class, 'destroy'] );
    Route::get('/{id}/recover', [UserController::class, 'recover'] );
});

Route::prefix('purchase')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'] );
    Route::put('/', [PurchaseController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseController::class, 'card'] );
    Route::post('/{id}', [PurchaseController::class, 'update'] );
    Route::delete('/{id}', [PurchaseController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseController::class, 'recover'] );
});

Route::prefix('purchase_delivery_address')->group(function () {
    Route::get('/', [PurchaseDeliveryAddressController::class, 'index'] );
    Route::put('/', [PurchaseDeliveryAddressController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseDeliveryAddressController::class, 'card'] );
    Route::post('/{id}', [PurchaseDeliveryAddressController::class, 'update'] );
    Route::delete('/{id}', [PurchaseDeliveryAddressController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseDeliveryAddressController::class, 'recover'] );
});

Route::prefix('purchase_invoice')->group(function () {
    Route::get('/', [PurchaseInvoiceController::class, 'index'] );
    Route::put('/', [PurchaseInvoiceController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseInvoiceController::class, 'card'] );
    Route::post('/{id}', [PurchaseInvoiceController::class, 'update'] );
    Route::delete('/{id}', [PurchaseInvoiceController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseInvoiceController::class, 'recover'] );
});

Route::prefix('purchase_account_supplier')->group(function () {
    Route::get('/', [PurchaseAccountSupplierController::class, 'index'] );
    Route::put('/', [PurchaseAccountSupplierController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseAccountSupplierController::class, 'card'] );
    Route::post('/{id}', [PurchaseAccountSupplierController::class, 'update'] );
    Route::delete('/{id}', [PurchaseAccountSupplierController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseAccountSupplierController::class, 'recover'] );
});

Route::prefix('purchase_receipts')->group(function () {
    Route::get('/', [PurchaseReceiptsController::class, 'index'] );
    Route::put('/', [PurchaseReceiptsController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseReceiptsController::class, 'card'] );
    Route::post('/{id}', [PurchaseReceiptsController::class, 'update'] );
    Route::delete('/{id}', [PurchaseReceiptsController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseReceiptsController::class, 'recover'] );
});

Route::prefix('purchase_expenses')->group(function () {
    Route::get('/', [PurchaseExpenseController::class, 'index'] );
    Route::put('/', [PurchaseExpenseController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseExpenseController::class, 'card'] );
    Route::post('/{id}', [PurchaseExpenseController::class, 'update'] );
    Route::delete('/{id}', [PurchaseExpenseController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseExpenseController::class, 'recover'] );
});