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
        Schema::table('counterparties', function (Blueprint $table) {
            $table->foreignId('counterparty_type_id')
                ->nullable()
                // ->constrained('directory_counterparty_types')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
    }
};
