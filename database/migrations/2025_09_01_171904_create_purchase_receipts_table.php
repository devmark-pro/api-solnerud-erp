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
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->id();
            $table->date('dispatch_date')->nullable();  
            $table->date('arrival_date')->nullable();  
            
            $table->string('invoice_supplier_number')->nullable();
            $table->longText('invoice_supplier_file')->nullable();
            $table->date('invoice_supplier_date')->nullable();

            $table->string('invoice_our_number')->nullable();
            $table->longText('invoice_our_file')->nullable();
            $table->date('invoice_our_date')->nullable();

            $table->string('transport')->nullable();
            $table->foreignId('address_id')->constrained('purchase_delivery_addresses');
         
            $table->foreignId('warehouse_id')->nullable()->constrained('directory_warehouses');
            $table->float('quantity');
            $table->foreignId('user_id')->nullable()->constrained();
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
        Schema::dropIfExists('purchase_receipts');
    }
};
