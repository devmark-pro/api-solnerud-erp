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
        if (Schema::hasColumn('sale_products', 'purchase_id')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('purchase_id');
            });
        }
        if (Schema::hasColumn('sale_product_purchases', 'warehouse_remains_id')) {
            Schema::table('sale_product_purchases', function (Blueprint $table) {
                $table->dropColumn('warehouse_remains_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        if (!Schema::hasColumn('sale_products', 'purchase_id')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->foreignId('purchase_id')->nullable()->constrained();
            });
        }
        if (!Schema::hasColumn('sale_product_purchases', 'warehouse_remains_id')) {
            Schema::table('sale_product_purchases', function (Blueprint $table) {
                $table->foreignId('warehouse_remains_id')->nullable()->constrained();
            });
        }
           
    }
};
