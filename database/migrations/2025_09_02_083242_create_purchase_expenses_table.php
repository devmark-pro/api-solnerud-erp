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

            $table->date('service_date_from')->nullable();   // Дата услуги
            $table->date('service_date_to')->nullable();   // Дата услуги

            $table->foreignId('address_id')->constrained('purchase_delivery_addresses');
            $table->string('name')->nullable();
            
            $table->string('executor_type'); // Исполнитель или контрагент  user | counterparty

            $table->foreignId('executor_user_id')->nullable()
                ->constrained('users');     // Исполнитель сотрудник

            $table->string('executor_counterparty_id')->nullable()
                ->constrained('counterparties');     // Исполнитель контрагент


            $table->float('rate')->nullable();  // Ставка

            $table->decimal('summ', 14, 2)->default(0)->nullable();
            $table->decimal('summ_nds', 14, 2)->default(0)->nullable();

            $table->integer('quantity')->nullable();  // Количество
            $table->boolean('include_in_cost')->default(true);     // Учет в себес.
            
            //Документы id
            // Возмещение расходов
            $table->string('reimbursement_expenses'); 
                //    'refunded',     // Возмещен
                //    'required',     // Требуется   
                //    'not_required'  // Не требуется  
                
            $table->date('reimbursement_date')->nullable(); //Дата возмещения
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
