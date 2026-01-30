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
use App\Http\Controllers\WarehouseRemains\WarehouseRemainsController;


use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Sale\SaleInvoiceController;
use App\Http\Controllers\Sale\SaleAccountSupplierController;
use App\Http\Controllers\Sale\SaleContractAndSpecificationController;
use App\Http\Controllers\Sale\SaleProduct\SaleProductController;
use App\Http\Controllers\Sale\SaleProduct\SaleProductPurchaseController;
use App\Http\Controllers\Sale\SaleShipmentController;
use App\Http\Controllers\Sale\SaleExpense\SaleExpenseController;
use App\Http\Controllers\Sale\SaleExpense\SaleExpenseDocumentController;
use App\Http\Controllers\Sale\SaleExpense\SaleExpenseProductController;
use App\Http\Controllers\Client\ClientWarehouseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Counterparty\CounterpartyWarehouseController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Expense\ExpenseDocumentController;
use App\Http\Controllers\Report\SaleReportController;
use App\Http\Controllers\Report\WarehouseRemainReportController;


// Route::post('/profile', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['middleware' => ['web']], function () {
    Route::post('/login', [AuthController::class, 'login']);
});


    
Route::group(['middleware' => ['web', 'auth:sanctum']], function () {

    Route::post('/change-password',[AuthController::class, 'changePassword'] );
    Route::post('profile/', [ProfileController::class, 'index']);
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
        Route::get('/field/{id}/{field}', [UserDocumentController::class, 'field'] );
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


    Route::prefix('warehouse')->group(function () {
        Route::post('/', [WarehouseController::class,  'index']);
        Route::post('/create', [WarehouseController::class, 'create'] ); 
        Route::post('/get', [WarehouseController::class, 'card'] );
        Route::post('/update', [WarehouseController::class, 'update'] );
        Route::post('/delete', [WarehouseController::class, 'destroy'] );
        Route::post('/recover', [WarehouseController::class, 'recover'] );
    });


    Route::prefix('warehouse_remains')->group(function () {
        Route::post('/', [WarehouseRemainsController::class,  'index']);
        Route::post('/create', [WarehouseRemainsController::class, 'create'] ); 
        Route::post('/get', [WarehouseRemainsController::class, 'card'] );
        Route::post('/update', [WarehouseRemainsController::class, 'update'] );
        Route::post('/delete', [WarehouseRemainsController::class, 'destroy'] );
        Route::post('/recover', [WarehouseRemainsController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [WarehouseRemainsController::class, 'field'] );
    });




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

    Route::prefix('client_warehouse')->group(function () {
        Route::post('/', [ClientWarehouseController::class,  'index']);
        Route::post('/create', [ClientWarehouseController::class, 'create'] ); 
        Route::post('/get', [ClientWarehouseController::class, 'card'] );
        Route::post('/update', [ClientWarehouseController::class, 'update'] );
        Route::post('/delete', [ClientWarehouseController::class, 'destroy'] );
        Route::post('/recover', [ClientWarehouseController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [ClientWarehouseController::class, 'field'] );
    });

    Route::prefix('counterparty_warehouse')->group(function () {
        Route::post('/', [CounterpartyWarehouseController::class,  'index']);
        Route::post('/create', [CounterpartyWarehouseController::class, 'create'] ); 
        Route::post('/get', [CounterpartyWarehouseController::class, 'card'] );
        Route::post('/update', [CounterpartyWarehouseController::class, 'update'] );
        Route::post('/delete', [CounterpartyWarehouseController::class, 'destroy'] );
        Route::post('/recover', [CounterpartyWarehouseController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [CounterpartyWarehouseController::class, 'field'] );
    });

    Route::prefix('role')->group(function () {
        Route::post('/', [RoleController::class,  'index']);
        Route::post('/create', [RoleController::class, 'create'] ); 
        Route::post('/get', [RoleController::class, 'card'] );
        Route::post('/update', [RoleController::class, 'update'] );
        Route::post('/delete', [RoleController::class, 'destroy'] );
        Route::post('/recover', [RoleController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [RoleController::class, 'field'] );
    });

    Route::prefix('expense')->group(function () {
        Route::post('/', [ExpenseController::class,  'index']);
        Route::post('/create', [ExpenseController::class, 'create'] ); 
        Route::post('/get', [ExpenseController::class, 'card'] );
        Route::post('/update', [ExpenseController::class, 'update'] );
        Route::post('/delete', [ExpenseController::class, 'destroy'] );
        Route::post('/recover', [ExpenseController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [ExpenseController::class, 'field'] );
    });

    Route::prefix('expense_document')->group(function () {
        Route::post('/', [ExpenseDocumentController::class,  'index']);
        Route::post('/create', [ExpenseDocumentController::class, 'create'] ); 
        Route::post('/get', [ExpenseDocumentController::class, 'card'] );
        Route::post('/update', [ExpenseDocumentController::class, 'update'] );
        Route::post('/delete', [ExpenseDocumentController::class, 'destroy'] );
        Route::post('/recover', [ExpenseDocumentController::class, 'recover'] );
        Route::get('/field/{id}/{field}', [ExpenseDocumentController::class, 'field'] );
    });
    Route::prefix('report')->group(function () {
        Route::post('/sale_report', [SaleReportController::class,  'index']);
        Route::post('/warehouse_remains_report', [WarehouseRemainReportController::class,  'index']);

        
    });
});
?>
