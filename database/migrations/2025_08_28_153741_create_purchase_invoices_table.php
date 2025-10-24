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
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('date');
            $table->decimal('summ', 14, 2);
            $table->decimal('summ_nds', 14, 2)->default(0);
            $table->string('nds_type'); // Тип НДС  
                                // no_nds  - Без НДС
                                // nds_in_price - НДС включен в цену
                                // nds_not_in_price - НДС не включен в цену


            $table->integer('nds_rate_id')->nullable()->constrained('directory_nds');  // Ставка

            $table->foreignId('user_id')->nullable()->constrained();
            $table->longText('file')->nullable();
            $table->date('deleted_at')->nullable();
            $table->foreignId('purchase_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
