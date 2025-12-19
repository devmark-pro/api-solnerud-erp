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
        Schema::table('sale_account_suppliers', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
        });
        if (Schema::hasColumn('sale_account_suppliers', 'nds_type')) {
            Schema::table('sale_account_suppliers', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }

        Schema::table('sale_contract_and_specifications', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
        });
        if (Schema::hasColumn('sale_contract_and_specifications', 'nds_type')) {
            Schema::table('sale_contract_and_specifications', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }

        Schema::table('sale_invoices', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
        });
        if (Schema::hasColumn('sale_invoices', 'nds_type')) {
            Schema::table('sale_invoices', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sale_invoices', 'is_nds_in_price')) {
            Schema::table('sale_invoices', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }

        if (Schema::hasColumn('sale_contract_and_specifications', 'is_nds_in_price')) {
            Schema::table('sale_contract_and_specifications', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }

        if (Schema::hasColumn('sale_account_suppliers', 'is_nds_in_price')) {
            Schema::table('sale_account_suppliers', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }
    }
};
