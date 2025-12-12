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
        Schema::create('sale_shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_product_id')->constrained();
            $table->foreignId('sale_product_purchase_id')->constrained();            
            $table->date('shipment_date');      // R Дата отгрузки
            $table->longText('file')->nullable();   //Накладная
            $table->string('file_number')->nullable();
            $table->date('file_date')->nullable();
            $table->string('transport')->nullable();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->float('shipped_quantity')->default(0);  //Отгружено
            $table->date('deleted_at')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_shipments');
    }
};
