<?php
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Purchase\PurchaseDeliveryAddressController;
use App\Http\Controllers\Purchase\PurchaseInvoiceController;
use App\Http\Controllers\Purchase\PurchaseAccountSupplierController;
use App\Http\Controllers\Purchase\PurchaseReceiptsController;
use App\Http\Controllers\Purchase\PurchaseExpense\PurchaseExpenseController;
use App\Http\Controllers\Purchase\PurchaseExpense\PurchaseExpenseDocumentController;
use App\Http\Controllers\Purchase\PurchaseExpense\PurchaseExpenseAddressController;
use App\Http\Controllers\Purchase\PurchaseDocumentController;

use App\Http\Controllers\Purchase\Selection\PurchaseNomenclatureController;
use App\Http\Controllers\Purchase\Selection\PurchasePackingTypeController;
use App\Http\Controllers\Purchase\Selection\PurchaseCounterpartyController;
use App\Http\Controllers\Purchase\Selection\PurchaseCounterpartyWarehouseController;
use App\Http\Controllers\Purchase\Selection\PurchaseClientWarehouseController;
use App\Http\Controllers\Purchase\Selection\PurchaseDeliveryMethodController;

Route::group(['middleware' => ['web', 'auth:sanctum']], function () {

    Route::prefix('purchase')->group(function () {
        Route::post('/', [PurchaseController::class, 'index'] );
        Route::post('/create', [PurchaseController::class, 'create'] ); 
        Route::post('/get', [PurchaseController::class, 'card'] );
        Route::post('/update', [PurchaseController::class, 'update'] );
        Route::post('/delete', [PurchaseController::class, 'destroy'] );
        Route::post('/recover', [PurchaseController::class, 'recover'] );

    });
    Route::prefix('purchase_selection_nomenclature')->group(function () {
        Route::post('/', [PurchaseNomenclatureController::class, 'index'] );
        Route::post('/get', [PurchaseNomenclatureController::class, 'card'] );   
    });
    Route::prefix('purchase_selection_packing_type')->group(function () {
        Route::post('/', [PurchasePackingTypeController::class, 'index'] );
        Route::post('/get', [PurchasePackingTypeController::class, 'card'] );   
    });
    Route::prefix('purchase_selection_packing_type')->group(function () {
        Route::post('/', [PurchasePackingTypeController::class, 'index'] );
        Route::post('/get', [PurchasePackingTypeController::class, 'card'] );   
    });

    Route::prefix('purchase_selection_counterparty')->group(function () {
        Route::post('/', [PurchaseCounterpartyController::class, 'index'] );
        Route::post('/get', [PurchaseCounterpartyController::class, 'card'] );
    });

    Route::prefix('purchase_selection_counterparty_warehouse')->group(function () {
        Route::post('/', [PurchaseCounterpartyWarehouseController::class, 'index'] );
        Route::post('/get', [PurchaseCounterpartyWarehouseController::class, 'card'] );
    });

    Route::prefix('purchase_selection_client_warehouse')->group(function () {
        Route::post('/', [PurchaseClientWarehouseController::class, 'index'] );
        Route::post('/get', [PurchaseClientWarehouseController::class, 'card'] );
    });

    Route::prefix('purchase_selection_delivery_method')->group(function () {
        Route::post('/', [PurchaseDeliveryMethodController::class, 'index'] );
        Route::post('/get', [PurchaseDeliveryMethodController::class, 'card'] );
    });

    Route::prefix('purchase_delivery_address')->group(function () {
        Route::post('/', [PurchaseDeliveryAddressController::class, 'index'] );
        Route::post('/create', [PurchaseDeliveryAddressController::class, 'create'] ); 
        Route::post('/get', [PurchaseDeliveryAddressController::class, 'card'] );
        Route::post('/update', [PurchaseDeliveryAddressController::class, 'update'] );
        Route::post('/delete', [PurchaseDeliveryAddressController::class, 'destroy'] );
        Route::post('/recover', [PurchaseDeliveryAddressController::class, 'recover'] );
    });

    Route::prefix('purchase_invoice')->group(function () {
        Route::post('/', [PurchaseInvoiceController::class, 'index'] );
        Route::post('/create', [PurchaseInvoiceController::class, 'create'] ); 
        Route::post('/get', [PurchaseInvoiceController::class, 'card'] );
        Route::post('/update', [PurchaseInvoiceController::class, 'update'] );
        Route::post('/delete', [PurchaseInvoiceController::class, 'destroy'] );
        Route::post('/recover', [PurchaseInvoiceController::class, 'recover'] );
        Route::get('field/{id}/{field}', [PurchaseInvoiceController::class, 'field'] );

    });

    Route::prefix('purchase_account_supplier')->group(function () {
        Route::post('/', [PurchaseAccountSupplierController::class, 'index'] );
        Route::post('/create', [PurchaseAccountSupplierController::class, 'create'] ); 
        Route::post('/get', [PurchaseAccountSupplierController::class, 'card'] );
        Route::post('/update', [PurchaseAccountSupplierController::class, 'update'] );
        Route::post('/delete', [PurchaseAccountSupplierController::class, 'destroy'] );
        Route::post('/recover', [PurchaseAccountSupplierController::class, 'recover'] );
    });

    Route::prefix('purchase_receipt')->group(function () {
        Route::post('/', [PurchaseReceiptsController::class, 'index'] );
        Route::post('/create', [PurchaseReceiptsController::class, 'create'] ); 
        Route::post('/get', [PurchaseReceiptsController::class, 'card'] );
        Route::post('/update', [PurchaseReceiptsController::class, 'update'] );
        Route::post('/delete', [PurchaseReceiptsController::class, 'destroy'] );
        Route::post('/recover', [PurchaseReceiptsController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [PurchaseReceiptsController::class, 'field'] );
    });

    Route::prefix('purchase_expenses')->group(function () {
        Route::post('/', [PurchaseExpenseController::class, 'index'] );
        Route::post('/create', [PurchaseExpenseController::class, 'create'] ); 
        Route::post('/get', [PurchaseExpenseController::class, 'card'] );
        Route::post('/update', [PurchaseExpenseController::class, 'update'] );
        Route::post('/delete', [PurchaseExpenseController::class, 'destroy'] );
        Route::post('/recover', [PurchaseExpenseController::class, 'recover'] );
    });

    Route::prefix('purchase_expense_document')->group(function () {
        Route::post('/', [PurchaseExpenseDocumentController::class,  'index']);
        Route::post('/create', [PurchaseExpenseDocumentController::class, 'create'] ); 
        Route::post('/get', [PurchaseExpenseDocumentController::class, 'card'] );
        Route::post('/update', [PurchaseExpenseDocumentController::class, 'update'] );
        Route::post('/delete', [PurchaseExpenseDocumentController::class, 'destroy'] );
        Route::post('/recover', [PurchaseExpenseDocumentController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [PurchaseExpenseDocumentController::class, 'field'] );
    });

    Route::prefix('purchase_expense_address')->group(function () {
        Route::post('/', [PurchaseExpenseAddressController::class,  'index']);
        Route::post('/create', [PurchaseExpenseAddressController::class, 'create'] ); 
        Route::post('/get', [PurchaseExpenseAddressController::class, 'card'] );
        Route::post('/update', [PurchaseExpenseAddressController::class, 'update'] );
        Route::post('/delete', [PurchaseExpenseAddressController::class, 'destroy'] );
        Route::post('/recover', [PurchaseExpenseAddressController::class, 'recover'] );
    });

    Route::prefix('purchase_document')->group(function () {
        Route::post('/', [PurchaseDocumentController::class, 'index'] );
        Route::post('/create', [PurchaseDocumentController::class, 'create'] ); 
        Route::post('/get', [PurchaseDocumentController::class, 'card'] );
        Route::post('/update', [PurchaseDocumentController::class, 'update'] );
        Route::post('/delete', [PurchaseDocumentController::class, 'destroy'] );
        Route::post('/recover', [PurchaseDocumentController::class, 'recover'] );
    });
    
});
?>