<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('sale_products', 'delivery_address')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('delivery_address');
            });
        }

        if (Schema::hasColumn('client_representatives', 'deleted_at')) {
            Schema::table('client_representatives', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('client_warehouses', 'deleted_at')) {
            Schema::table('client_warehouses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('clients', 'deleted_at')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('counterparties', 'deleted_at')) {
            Schema::table('counterparties', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('counterparty_representatives', 'deleted_at')) {
            Schema::table('counterparty_representatives', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('counterparty_warehouses', 'deleted_at')) {
            Schema::table('counterparty_warehouses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_counterparty_types', 'deleted_at')) {
            Schema::table('directory_counterparty_types', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_delivery_methods', 'deleted_at')) {
            Schema::table('directory_delivery_methods', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_employee_positions', 'deleted_at')) {
            Schema::table('directory_employee_positions', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_employee_statuses', 'deleted_at')) {
            Schema::table('directory_employee_statuses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_nds', 'deleted_at')) {
            Schema::table('directory_nds', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_packing_types', 'deleted_at')) {
            Schema::table('directory_packing_types', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_payment_types', 'deleted_at')) {
            Schema::table('directory_payment_types', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_position_representatives', 'deleted_at')) {
            Schema::table('directory_position_representatives', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_purchase_types', 'deleted_at')) {
            Schema::table('directory_purchase_types', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('directory_status_purchases', 'deleted_at')) {
            Schema::table('directory_status_purchases', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('directory_status_sales', 'deleted_at')) {
            Schema::table('directory_status_sales', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('directory_type_flows', 'deleted_at')) {
            Schema::table('directory_type_flows', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('directory_warehouses', 'deleted_at')) {
            Schema::table('directory_warehouses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('nomenclatures', 'deleted_at')) {
            Schema::table('nomenclatures', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('purchase_account_suppliers', 'deleted_at')) {
            Schema::table('purchase_account_suppliers', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('payment_date')->nullable()->change();                
            });
        }
        
        if (Schema::hasColumn('purchase_delivery_addresses', 'deleted_at')) {
            Schema::table('purchase_delivery_addresses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('purchase_expense_addresses', 'deleted_at')) {
            Schema::table('purchase_expense_addresses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('purchase_expense_documents', 'deleted_at')) {
            Schema::table('purchase_expense_documents', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('purchase_expenses', 'deleted_at')) {
            Schema::table('purchase_expenses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('service_date_from')->nullable()->change();
                $table->dateTimeTz('service_date_to')->nullable()->change();
                $table->dateTimeTz('reimbursement_date')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('purchase_invoices', 'deleted_at')) {
            Schema::table('purchase_invoices', function (Blueprint $table) {
                $table->dateTimeTz('date')->nullable()->change();
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        // if (Schema::hasColumn('', 'deleted_at')) {
        //     Schema::table('', function (Blueprint $table) {
        //         $table->dateTimeTz('deleted_at')->nullable()->change();
        //         $table->dateTimeTz('created_at')->nullable()->change();
        //         $table->dateTimeTz('updated_at')->nullable()->change();
        //     });
        // }
        if (Schema::hasColumn('purchase_receipts', 'deleted_at')) {
            Schema::table('purchase_receipts', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('dispatch_date')->nullable()->change();
                $table->dateTimeTz('arrival_date')->nullable()->change();
                $table->dateTimeTz('invoice_supplier_date')->nullable()->change();
                $table->dateTimeTz('invoice_our_date')->nullable()->change();       
            });
        }
        
        if (Schema::hasColumn('purchases', 'deleted_at')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        
        if (Schema::hasColumn('sale_account_suppliers', 'deleted_at')) {
            Schema::table('sale_account_suppliers', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('payment_date')->nullable()->change();                
            });
        }
        
        if (Schema::hasColumn('sale_contract_and_specifications', 'deleted_at')) {
            Schema::table('sale_contract_and_specifications', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('date')->nullable();//->change();
            });
        }
        
        if (Schema::hasColumn('sale_expense_documents', 'deleted_at')) {
            Schema::table('sale_expense_documents', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('sale_expense_products', 'deleted_at')) {
            Schema::table('sale_expense_products', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();

            });
        }
        if (Schema::hasColumn('sale_expenses', 'deleted_at')) {
            Schema::table('sale_expenses', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('service_date_from')->nullable()->change();
                $table->dateTimeTz('service_date_to')->nullable()->change();
                $table->dateTimeTz('reimbursement_date')->nullable()->change();
               
            });
        }
        if (Schema::hasColumn('sale_invoices', 'deleted_at')) {
            Schema::table('sale_invoices', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('date')->nullable()->change();
            });
        }
        if (Schema::hasColumn('sale_product_purchases', 'deleted_at')) {
            Schema::table('sale_product_purchases', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        if (Schema::hasColumn('sale_products', 'deleted_at')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('delivery_date')->nullable()->change();
            });
        }
        if (Schema::hasColumn('sale_shipments', 'deleted_at')) {
            Schema::table('sale_shipments', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
                $table->dateTimeTz('shipment_date')->nullable()->change();
                $table->dateTimeTz('file_date')->nullable()->change();
            });
        }
        if (Schema::hasColumn('sales', 'deleted_at')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('user_documents', 'deleted_at')) {
            Schema::table('user_documents', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        if (Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }
        if (Schema::hasColumn('warehouse_remains', 'deleted_at')) {
            Schema::table('warehouse_remains', function (Blueprint $table) {
                $table->dateTimeTz('deleted_at')->nullable()->change();
                $table->dateTimeTz('created_at')->nullable()->change();
                $table->dateTimeTz('updated_at')->nullable()->change();
            });
        }

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        if (Schema::hasColumn('sale_contract_and_specifications', 'date')) {
            Schema::table('sale_contract_and_specifications', function (Blueprint $table) {
                $table->dropColumn('date');
            });
        }
    }
};
