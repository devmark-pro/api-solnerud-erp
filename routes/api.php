<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/status', function (Request $request) {
//     return '111';
// });


Route::prefix('status')->group(function () {
    Route::get('/', [StatusController::class, 'index'] );
    Route::post('/', [StatusController::class, 'create'] ); 
    Route::get('/{id}', [StatusController::class, 'card'] );
    Route::put('/', [StatusController::class, 'update'] );
    Route::delete('/{id}', [StatusController::class, 'destroy'] );

});

