<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Counterparty\CounterpartyController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientRepresentativeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserDocumentController;
use App\Http\Controllers\WarehouseController;

use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Purchase\PurchaseDeliveryAddressController;
use App\Http\Controllers\Purchase\PurchaseInvoiceController;
use App\Http\Controllers\Purchase\PurchaseAccountSupplierController;
use App\Http\Controllers\Purchase\PurchaseReceiptsController;
use App\Http\Controllers\Purchase\PurchaseExpense\PurchaseExpenseController;
use App\Http\Controllers\Purchase\PurchaseExpense\PurchaseExpenseDocumentController;
use App\Http\Controllers\Purchase\PurchaseExpense\PurchaseExpenseAddressController;

use App\Http\Controllers\Purchase\PurchaseDocumentController;

use App\Http\Controllers\Counterparty\CounterpartyRepresentativeController;

use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::prefix('counterparty')->group(function () {
    Route::post('/', [CounterpartyController::class, 'index'] );
    Route::post('/create', [CounterpartyController::class, 'create'] ); 
    Route::post('/get', [CounterpartyController::class, 'card'] );
    Route::post('/update', [CounterpartyController::class, 'update'] );
    Route::post('/delete', [CounterpartyController::class, 'destroy'] );
    Route::post('/recover', [CounterpartyController::class, 'recover'] );
});


Route::prefix('counterparty_representative')->group(function () {
    Route::post('/', [CounterpartyRepresentativeController::class,  'index']);
    Route::post('/create', [CounterpartyRepresentativeController::class, 'create'] ); 
    Route::post('/get', [CounterpartyRepresentativeController::class, 'card'] );
    Route::post('/update', [CounterpartyRepresentativeController::class, 'update'] );
    Route::post('/delete', [CounterpartyRepresentativeController::class, 'destroy'] );
    Route::post('/recover', [CounterpartyRepresentativeController::class, 'recover'] );
});


Route::prefix('nomenclature')->group(function () {
    Route::post('/', [NomenclatureController::class, 'index'] );
    Route::post('/create', [NomenclatureController::class, 'create'] ); 
    Route::post('/get', [NomenclatureController::class, 'card'] );
    Route::post('/update', [NomenclatureController::class, 'update'] );
    Route::post('/delete', [NomenclatureController::class, 'destroy'] );
    Route::post('/recover', [NomenclatureController::class, 'recover'] );
});

Route::prefix('client')->group(function () {
    Route::post('/', [ClientController::class, 'index'] );
    Route::post('/create', [ClientController::class, 'create'] ); 
    Route::post('/get', [ClientController::class, 'card'] );
    Route::post('/update', [ClientController::class, 'update'] );
    Route::post('/delete', [ClientController::class, 'destroy'] );
    Route::post('/recover', [ClientController::class, 'recover'] );
});

Route::prefix('client_representative')->group(function () {
    Route::post('/', [ClientRepresentativeController::class,  'index']);
    Route::post('/create', [ClientRepresentativeController::class, 'create'] ); 
    Route::post('/get', [ClientRepresentativeController::class, 'card'] );
    Route::post('/update', [ClientRepresentativeController::class, 'update'] );
    Route::post('/delete', [ClientRepresentativeController::class, 'destroy'] );
    Route::post('/recover', [ClientRepresentativeController::class, 'recover'] );
});

Route::prefix('user')->group(function () {
    Route::post('/', [UserController::class, 'index'] );
    Route::post('/create', [UserController::class, 'create'] ); 
    Route::post('/get', [UserController::class, 'card'] );
    Route::post('/update', [UserController::class, 'update'] );
    Route::post('/delete', [UserController::class, 'destroy'] );
    Route::post('/recover', [UserController::class, 'recover'] );
});

Route::prefix('user_document')->group(function () {
    Route::post('/', [UserDocumentController::class,  'index']);
    Route::post('/create', [UserDocumentController::class, 'create'] ); 
    Route::post('/get', [UserDocumentController::class, 'card'] );
    Route::post('/update', [UserDocumentController::class, 'update'] );
    Route::post('/delete', [UserDocumentController::class, 'destroy'] );
    Route::post('/recover', [UserDocumentController::class, 'recover'] );
});

Route::prefix('purchase')->group(function () {
    Route::post('/', [PurchaseController::class, 'index'] );
    Route::post('/create', [PurchaseController::class, 'create'] ); 
    Route::post('/get', [PurchaseController::class, 'card'] );
    Route::post('/update', [PurchaseController::class, 'update'] );
    Route::post('/delete', [PurchaseController::class, 'destroy'] );
    Route::post('/recover', [PurchaseController::class, 'recover'] );
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
});
Route::prefix('user_document')->group(function () {
    Route::post('/', [UserDocumentController::class,  'index']);
    Route::post('/create', [UserDocumentController::class, 'create'] ); 
    Route::post('/get', [UserDocumentController::class, 'card'] );
    Route::post('/update', [UserDocumentController::class, 'update'] );
    Route::post('/delete', [UserDocumentController::class, 'destroy'] );
    Route::post('/recover', [UserDocumentController::class, 'recover'] );
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


Route::prefix('warehouse')->group(function () {
    Route::post('/', [WarehouseController::class,  'index']);
    Route::post('/create', [WarehouseController::class, 'create'] ); 
    Route::post('/get', [WarehouseController::class, 'card'] );
    Route::post('/update', [WarehouseController::class, 'update'] );
    Route::post('/delete', [WarehouseController::class, 'destroy'] );
    Route::post('/recover', [WarehouseController::class, 'recover'] );
});





?>
