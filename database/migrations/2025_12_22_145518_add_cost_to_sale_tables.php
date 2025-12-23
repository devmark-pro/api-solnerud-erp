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
        Schema::table('sale_products', function (Blueprint $table) {
            $table->foreignId('purchase_id')->nullable()->constrained();
            $table->foreignId('purchase_address_id')->nullable()->constrained('purchase_delivery_addresses');
            $table->decimal('total_cost', 14, 2)->default(0)->nullable();
        });
        Schema::table('sale_expenses', function (Blueprint $table) {
            $table->decimal('cost', 14, 2)->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sale_products', 'purchase_id')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('purchase_id');
            });
        }
        if (Schema::hasColumn('sale_products', 'purchase_address_id')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('purchase_address_id');
            });
        }
        if (Schema::hasColumn('sale_products', 'total_cost')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('total_cost');
            });
        }
        if (Schema::hasColumn('sale_expenses', 'cost')) {
            Schema::table('sale_expenses', function (Blueprint $table) {
                $table->dropColumn('cost');
            });
        }
    }
};
