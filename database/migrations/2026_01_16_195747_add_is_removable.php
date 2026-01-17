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
        //
        
        Schema::table('sale_products', function (Blueprint $table) {
            $table->boolean('is_updatable')->default(true);
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->boolean('is_updatable')->default(true);
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->boolean('is_updatable')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sale_products', 'is_updatable')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('is_updatable');
            });
        }

        if (Schema::hasColumn('sales', 'is_updatable')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('is_updatable');
            });
        }
        
        if (Schema::hasColumn('purchases', 'is_updatable')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('is_updatable');
            });
        }
    }
};
