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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_sale_id')
                ->nullable()
                ->constrained('directory_status_sales'); // статус 
            $table->foreignId('client_id')->constrained();         // покупатель
            $table->text('comment')->nullable();
            $table->float('quantity')->default(0);    // план тон
            $table->decimal('summ', 14, 2)->default(0)->nullable();
            $table->decimal('summ_nds', 14, 2)->default(0)->nullable();
            $table->foreignId('counterparty_id')->nullable()->constrained();   // поставщик
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
