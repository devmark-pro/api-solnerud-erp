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
        Schema::create('purchase_expenses', function (Blueprint $table) {
            $table->id();

            $table->date('service_date')->nullable();
            $table->foreignId('address_id')->constrained('purchase_delivery_addresses');
            $table->string('name')->nullable();
            $table->string('executor');
            $table->float('rate')->nullable();  // Ставка
            $table->float('quantity')->nullable();  // Количество
            $table->float('summ');                  // Сумма
            $table->float('summ_nds')->default(0);  // Сумма НДС    
            $table->boolean('include_in_cost')->default(true);     // Учет в себес.
            $table->enum('reimbursement_expenses', 
                [
                    'refunded',     // Возмещен
                    'required',     // Требуется   
                    'not_required'  // Не требуется  
                ]
            )->nullable();
            $table->date('reimbursement_date')->nullable();
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
        Schema::dropIfExists('purchase_expenses');
    }
};
