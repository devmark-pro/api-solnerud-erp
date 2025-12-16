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
        Schema::create('sale_expense_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('sale_expense_id')->constrained();
            $table->foreignId('sale_product_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            
            $table->date('deleted_at')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_expense_products');
    }
};
