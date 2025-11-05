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
            $table->float('actual_quantity')->default(0)->nullable();
            $table->float('remaining_quantity')->default(0)->nullable();
            $table->decimal('cost', 14, 2)->default(0)->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_delivery_addresses', function (Blueprint $table) {
            $table->dropColumn('actual_quantity');
            $table->dropColumn('remaining_quantity');
            $table->dropColumn('cost');   
 
        });
    }
};
