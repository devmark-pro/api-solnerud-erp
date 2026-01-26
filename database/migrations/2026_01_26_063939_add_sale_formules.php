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
        Schema::table('sale_expenses', function (Blueprint $table) {
            $table->string('cost_formula')->nullable();
        });

        Schema::table('sale_products', function (Blueprint $table) {
            $table->string('cost_formula')->nullable();
        });
        Schema::table('sale_products', function (Blueprint $table) {
            $table->string('total_cost_formula')->nullable();
        });
        Schema::table('sale_products', function (Blueprint $table) {
            $table->string('profit_formula')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        if (Schema::hasColumn('sale_expenses', 'cost_formula')) {
            Schema::table('sale_expenses', function (Blueprint $table) {
                $table->dropColumn('cost_formula');
            });
        }
        if (Schema::hasColumn('sale_products', 'cost_formula')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('cost_formula');
            });
        }
        if (Schema::hasColumn('sale_products', 'total_cost_formula')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('total_cost_formula');
            });
        }
        if (Schema::hasColumn('sale_products', 'profit_formula')) {
            Schema::table('sale_products', function (Blueprint $table) {
                $table->dropColumn('profit_formula');
            });
        }
    }
};
