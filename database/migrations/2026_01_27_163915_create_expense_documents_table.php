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
        Schema::create('expense_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->dateTimeTz('date')->nullable();    
            $table->longText('file')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('expense_id')->constrained();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_documents');
    }
};
