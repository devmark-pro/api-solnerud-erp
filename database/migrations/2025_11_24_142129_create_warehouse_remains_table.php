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
        Schema::create('warehouse_remains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nomenclature_id')->constrained();    // товар
            $table->foreignId('purchase_id')->constrained();
            $table->foreignId('warehouse_id')->nullable()->constrained('directory_warehouses');       
            $table->foreignId('packing_type_id')
                ->nullable()
                ->constrained('directory_packing_types');           //тип фасовки

            $table->float('availability')->default(0)->nullable();
            $table->float('reserve')->default(0)->nullable();
            $table->float('presence')->default(0)->nullable();
            $table->decimal('cost', 14, 2)->default(0)->nullable(); // Себестоимость
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_remains');
    }
};
