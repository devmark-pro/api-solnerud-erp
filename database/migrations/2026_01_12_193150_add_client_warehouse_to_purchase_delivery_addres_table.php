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
        Schema::table('purchase_delivery_addresses', function (Blueprint $table) {
            $table->foreignId('client_warehouse_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('purchase_delivery_addresses', 'client_warehouse_id')) {
            Schema::table('purchase_delivery_addresses', function (Blueprint $table) {
                $table->dropColumn('client_warehouse_id');
            });
        }
    }
};
