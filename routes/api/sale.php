<?php

use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Sale\SaleInvoiceController;
use App\Http\Controllers\Sale\SaleAccountSupplierController;
use App\Http\Controllers\Sale\SaleContractAndSpecificationController;
use App\Http\Controllers\Sale\SaleProduct\SaleProductController;
use App\Http\Controllers\Sale\SaleProduct\SaleProductPurchaseController;
use App\Http\Controllers\Sale\SaleShipment\SaleShipmentController;
use App\Http\Controllers\Sale\SaleExpense\SaleExpenseController;
use App\Http\Controllers\Sale\SaleExpense\SaleExpenseDocumentController;
use App\Http\Controllers\Sale\SaleExpense\SaleExpenseProductController;
use App\Http\Controllers\Purchase\Selection\PurchaseDeliveryMethodController;
use App\Http\Controllers\Sale\SaleShipment\Selection\SaleShipmentProductSelectionController;


Route::group(['middleware' => ['web', 'auth:sanctum']], function () {
    Route::prefix('sale')->group(function () {
        Route::post('/', [SaleController::class,  'index']);
        Route::post('/create', [SaleController::class, 'create'] ); 
        Route::post('/get', [SaleController::class, 'card'] );
        Route::post('/update', [SaleController::class, 'update'] );
        Route::post('/delete', [SaleController::class, 'destroy'] );
        Route::post('/recover', [SaleController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleController::class, 'field'] );
    });

    Route::prefix('sale_invoice')->group(function () {
        Route::post('/', [SaleInvoiceController::class,  'index']);
        Route::post('/create', [SaleInvoiceController::class, 'create'] ); 
        Route::post('/get', [SaleInvoiceController::class, 'card'] );
        Route::post('/update', [SaleInvoiceController::class, 'update'] );
        Route::post('/delete', [SaleInvoiceController::class, 'destroy'] );
        Route::post('/recover', [SaleInvoiceController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleInvoiceController::class, 'field'] );
    });

    Route::prefix('sale_account_supplier')->group(function () {
        Route::post('/', [SaleAccountSupplierController::class,  'index']);
        Route::post('/create', [SaleAccountSupplierController::class, 'create'] ); 
        Route::post('/get', [SaleAccountSupplierController::class, 'card'] );
        Route::post('/update', [SaleAccountSupplierController::class, 'update'] );
        Route::post('/delete', [SaleAccountSupplierController::class, 'destroy'] );
        Route::post('/recover', [SaleAccountSupplierController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleAccountSupplierController::class, 'field'] );
    });



    Route::prefix('sale_contract_and_specification')->group(function () {
        Route::post('/', [SaleContractAndSpecificationController::class,  'index']);
        Route::post('/create', [SaleContractAndSpecificationController::class, 'create'] ); 
        Route::post('/get', [SaleContractAndSpecificationController::class, 'card'] );
        Route::post('/update', [SaleContractAndSpecificationController::class, 'update'] );
        Route::post('/delete', [SaleContractAndSpecificationController::class, 'destroy'] );
        Route::post('/recover', [SaleContractAndSpecificationController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleContractAndSpecificationController::class, 'field'] );
    });

    Route::prefix('sale_product')->group(function () {
        Route::post('/', [SaleProductController::class,  'index']);
        Route::post('/create', [SaleProductController::class, 'create'] ); 
        Route::post('/get', [SaleProductController::class, 'card'] );
        Route::post('/update', [SaleProductController::class, 'update'] );
        Route::post('/delete', [SaleProductController::class, 'destroy'] );
        Route::post('/recover', [SaleProductController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleProductController::class, 'field'] );
    });

    Route::prefix('sale_product_purchase')->group(function () {
        Route::post('/', [SaleProductPurchaseController::class,  'index']);
        Route::post('/create', [SaleProductPurchaseController::class, 'create'] ); 
        Route::post('/get', [SaleProductPurchaseController::class, 'card'] );
        Route::post('/update', [SaleProductPurchaseController::class, 'update'] );
        Route::post('/delete', [SaleProductPurchaseController::class, 'destroy'] );
        Route::post('/recover', [SaleProductPurchaseController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleProductPurchaseController::class, 'field'] );
    });

    Route::prefix('sale_shipment')->group(function () {
        Route::post('/', [SaleShipmentController::class,  'index']);
        Route::post('/create', [SaleShipmentController::class, 'create'] ); 
        Route::post('/get', [SaleShipmentController::class, 'card'] );
        Route::post('/update', [SaleShipmentController::class, 'update'] );
        Route::post('/delete', [SaleShipmentController::class, 'destroy'] );
        Route::post('/recover', [SaleShipmentController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleShipmentController::class, 'field'] );
    });

    Route::prefix('sale_expense')->group(function () {
        Route::post('/', [SaleExpenseController::class,  'index']);
        Route::post('/create', [SaleExpenseController::class, 'create'] ); 
        Route::post('/get', [SaleExpenseController::class, 'card'] );
        Route::post('/update', [SaleExpenseController::class, 'update'] );
        Route::post('/delete', [SaleExpenseController::class, 'destroy'] );
        Route::post('/recover', [SaleExpenseController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleExpenseController::class, 'field'] );
    });

    Route::prefix('sale_expense_document')->group(function () {
        Route::post('/', [SaleExpenseDocumentController::class,  'index']);
        Route::post('/create', [SaleExpenseDocumentController::class, 'create'] ); 
        Route::post('/get', [SaleExpenseDocumentController::class, 'card'] );
        Route::post('/update', [SaleExpenseDocumentController::class, 'update'] );
        Route::post('/delete', [SaleExpenseDocumentController::class, 'destroy'] );
        Route::post('/recover', [SaleExpenseDocumentController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleExpenseDocumentController::class, 'field'] );
    });


    Route::prefix('sale_expense_product')->group(function () {
        Route::post('/', [SaleExpenseProductController::class,  'index']);
        Route::post('/create', [SaleExpenseProductController::class, 'create'] ); 
        Route::post('/get', [SaleExpenseProductController::class, 'card'] );
        Route::post('/update', [SaleExpenseProductController::class, 'update'] );
        Route::post('/delete', [SaleExpenseProductController::class, 'destroy'] );
        Route::post('/recover', [SaleExpenseProductController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [SaleExpenseProductController::class, 'field'] );
    });

    Route::prefix('sale_shipment_selection_product')->group(function () {
        Route::post('/', [SaleShipmentProductSelectionController::class, 'index'] );
        Route::post('/get', [SaleShipmentProductSelectionController::class, 'card'] );
    });
});

?>