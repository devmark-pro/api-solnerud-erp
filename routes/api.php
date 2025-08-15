<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusPurchaseController;
use App\Http\Controllers\StatusSaleController;

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

