<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CounterpartyController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;


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

Route::prefix('purchase')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'] );
    Route::put('/', [PurchaseController::class, 'create'] ); 
    Route::get('/{id}', [PurchaseController::class, 'card'] );
    Route::post('/{id}', [PurchaseController::class, 'update'] );
    Route::delete('/{id}', [PurchaseController::class, 'destroy'] );
    Route::get('/{id}/recover', [PurchaseController::class, 'recover'] );
});


Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'] );
    Route::put('/', [UserController::class, 'create'] ); 
    Route::get('/{id}', [UserController::class, 'card'] );
    Route::post('/{id}', [UserController::class, 'update'] );
    Route::delete('/{id}', [UserController::class, 'destroy'] );
    Route::get('/{id}/recover', [UserController::class, 'recover'] );
});

