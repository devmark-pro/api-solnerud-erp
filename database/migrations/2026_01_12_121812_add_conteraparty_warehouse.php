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
            $table->foreignId('counterparty_warehouse_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('purchases', 'counterparty_warehouse_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('counterparty_warehouse_id');
            });
        }
    }
};
