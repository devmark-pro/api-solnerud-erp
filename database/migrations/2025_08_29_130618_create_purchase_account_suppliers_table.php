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
        Schema::create('purchase_account_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_type_id')
                ->constrained('directory_payment_types');  // тип оплаты
            $table->float('summ');  
            $table->float('summ_nds')->default(0); 
            $table->float('paid')->default(0);  
            $table->date('payment_data')->nullable();  // срок оплаты
            $table->foreignId('purchase_id')->constrained();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_account_suppliers');
    }
};
