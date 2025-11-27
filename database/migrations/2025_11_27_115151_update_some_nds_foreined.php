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
            $table->dropColumn('nds_rate_id');
            $table->foreignId('nds_rate_id')->nullable()->constrained('directory_nds')->change();  
        });
    
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->dropColumn('nds_rate_id');
            $table->foreignId('nds_rate_id')->nullable()->constrained('directory_nds')->change();  
        });

        Schema::table('purchase_account_suppliers', function (Blueprint $table) {
            $table->dropColumn('nds_rate_id');
            $table->foreignId('nds_rate_id')->nullable()->constrained('directory_nds')->change(); 
        });

        Schema::table('purchase_expenses', function (Blueprint $table) {
            $table->dropColumn('nds_rate_id');
            $table->foreignId('nds_rate_id')->nullable()->constrained('directory_nds')->change(); 
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
