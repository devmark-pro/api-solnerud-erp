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
        if (Schema::hasIndex('counterparties', ['inn'], 'unique')) {
            Schema::table('counterparties', function (Blueprint $table) {
                $table->dropUnique(['inn']);
            });
        }
        if (Schema::hasIndex('clients', ['inn'], 'unique')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropUnique(['inn']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
