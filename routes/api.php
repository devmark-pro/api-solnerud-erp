<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\StatusPurchaseController;
use App\Http\Controllers\Directory\StatusSaleController;
use App\Http\Controllers\Directory\TypeFlowController;
use App\Http\Controllers\Directory\PaymentTypeController;



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



