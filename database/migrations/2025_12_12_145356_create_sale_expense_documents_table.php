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
        Schema::create('sale_expense_documents', function (Blueprint $table) {
            $table->id();
                 $table->string('name')->nullable();
            $table->date('date')->nullable();    
            
            $table->longText('file')->nullable();
            
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('sale_expense_id')->constrained();

            $table->date('deleted_at')->nullable();
       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_expense_documents');
    }
};
