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
            $table->foreignId('status_purchase_id')->constrained('directory_status_purchases');
            $table->foreignId('purchase_type_id')->constrained('directory_purchase_types');
            $table->foreignId('counterparty_id')->constrained();
            $table->foreignId('nomenclature_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('packing_type_id')->constrained('directory_packing_types');
            $table->foreignId('delivery_method_id')->constrained('directory_delivery_methods');
            $table->float('price')->default(0);
            $table->float('count_plan')->default(0);
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
