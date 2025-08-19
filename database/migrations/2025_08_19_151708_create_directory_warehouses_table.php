q<?php

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
        Schema::create('directory_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
            $table->string('warehouse_lessor');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directory_warehouses');
    }
};
