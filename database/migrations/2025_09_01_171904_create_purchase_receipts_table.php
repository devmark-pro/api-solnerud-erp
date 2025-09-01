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
            $table->string('invoice_supplier')->nullable();
            $table->string('invoice_our')->nullable();
            $table->string('transport')->nullable();
            $table->string('delivery_address')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('directory_warehouses');
            $table->float('quantity')->nullable();
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
