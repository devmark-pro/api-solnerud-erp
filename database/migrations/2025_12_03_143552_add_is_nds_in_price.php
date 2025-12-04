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
        Schema::table('purchases', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
            $table->decimal('nds_rate', 14, 2)->default(null)->nullable()->change(); 
          });
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
            $table->decimal('nds_rate', 14, 2)->default(null)->nullable()->change(); 
          });

        Schema::table('purchase_account_suppliers', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
            $table->decimal('nds_rate', 14, 2)->default(null)->nullable()->change(); 
        });

        Schema::table('purchase_expenses', function (Blueprint $table) {
            $table->boolean('is_nds_in_price')->default(false);
            $table->decimal('nds_rate', 14, 2)->default(null)->nullable()->change(); 
        });

        if (Schema::hasColumn('purchases', 'nds_type')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }
        if (Schema::hasColumn('purchase_invoices', 'nds_type')) {
            Schema::table('purchase_invoices', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }
        if (Schema::hasColumn('purchase_account_suppliers','nds_type')) {
            Schema::table('purchase_account_suppliers', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }
        if (Schema::hasColumn('purchase_expenses', 'nds_type')) {
            Schema::table('purchase_expenses', function (Blueprint $table) {
                $table->dropColumn('nds_type');
            });
        }
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('purchases', 'is_nds_in_price')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }
        if (Schema::hasColumn('purchase_invoices', 'is_nds_in_price')) {
            Schema::table('purchase_invoices', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }
        if (Schema::hasColumn('purchase_account_suppliers','is_nds_in_price')) {
            Schema::table('purchase_account_suppliers', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }
        if (Schema::hasColumn('purchase_expenses', 'is_nds_in_price')) {
            Schema::table('purchase_expenses', function (Blueprint $table) {
                $table->dropColumn('is_nds_in_price');
            });
        }
    }
};
