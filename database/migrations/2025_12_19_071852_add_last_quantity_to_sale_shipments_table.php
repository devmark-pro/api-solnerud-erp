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
        Schema::table('sale_shipments', function (Blueprint $table) {
            $table->float('last_quantity')->nullable();  // Количество
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sale_shipments', 'last_quantity')) {
            Schema::table('sale_shipments', function (Blueprint $table) {
                $table->dropColumn('last_quantity');
            });
        }
        
    }
};
