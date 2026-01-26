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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();

            $table->foreignId('user_id')->nullable()->constrained();

            $table->boolean('purchase_c')->default(false); 
            $table->boolean('purchase_r')->default(true); 
            $table->boolean('purchase_u')->default(false); 
            $table->boolean('purchase_d')->default(false); 

            $table->boolean('sale_c')->default(false); 
            $table->boolean('sale_r')->default(true); 
            $table->boolean('sale_u')->default(false); 
            $table->boolean('sale_d')->default(false); 

            $table->boolean('warehouse_remains_c')->default(false); 
            $table->boolean('warehouse_remains_r')->default(true); 
            $table->boolean('warehouse_remains_u')->default(false); 
            $table->boolean('warehouse_remains_d')->default(false); 

            $table->boolean('nomenclature_c')->default(false); 
            $table->boolean('nomenclature_r')->default(true); 
            $table->boolean('nomenclature_u')->default(false); 
            $table->boolean('nomenclature_d')->default(false); 

            $table->boolean('warehouse_c')->default(false); 
            $table->boolean('warehouse_r')->default(true); 
            $table->boolean('warehouse_u')->default(false); 
            $table->boolean('warehouse_d')->default(false); 

            $table->boolean('counterparty_c')->default(false); 
            $table->boolean('counterparty_r')->default(true); 
            $table->boolean('counterparty_u')->default(false); 
            $table->boolean('counterparty_d')->default(false); 

            $table->boolean('client_c')->default(false); 
            $table->boolean('client_r')->default(true); 
            $table->boolean('client_u')->default(false); 
            $table->boolean('client_d')->default(false); 

            $table->boolean('user_c')->default(false); 
            $table->boolean('user_r')->default(true); 
            $table->boolean('user_u')->default(false); 
            $table->boolean('user_d')->default(false); 

            $table->boolean('role_c')->default(false); 
            $table->boolean('role_r')->default(false); 
            $table->boolean('role_u')->default(false); 
            $table->boolean('role_d')->default(false);

            $table->boolean('directory_c')->default(false); 
            $table->boolean('directory_r')->default(false); 
            $table->boolean('directory_u')->default(false); 
            $table->boolean('directory_d')->default(false);

            $table->dateTimeTz('deleted_at')->nullable();

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
