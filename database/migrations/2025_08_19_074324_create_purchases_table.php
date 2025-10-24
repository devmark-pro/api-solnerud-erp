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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_purchase_id')
                ->nullable()
                ->constrained('directory_status_purchases'); // статус отгрузки
            
            $table->string('purchase_type')->nullable();           // to_warehouse | to_client   
            $table->foreignId('counterparty_id')->constrained();   // поставщик
            $table->foreignId('nomenclature_id')->constrained();   // товар
            $table->foreignId('client_id')->constrained();         // покупатель
            $table->foreignId('packing_type_id')
                ->nullable()
                ->constrained('directory_packing_types');   //тип фасовки
            $table->foreignId('delivery_method_id')
                ->constrained('directory_delivery_methods'); // доставка
            $table->float('price')->default(0);         // цена 
            $table->float('count_plan')->default(0);    // план тон
            $table->text('comment')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
