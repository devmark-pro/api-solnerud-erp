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
        Schema::table('purchases', function (Blueprint $table) {
        
            $table->integer('nds_rate_id')->nullable()->constrained('directory_nds');  // Ставка
            $table->decimal('summ', 14, 2)->default(0)->nullable();
            $table->decimal('summ_nds', 14, 2)->default(0)->nullable();
            $table->float('count')->default(0);
            $table->string('nds_type')->default('no_nds'); // Тип НДС  
                                // no_nds  - Без НДС
                                // nds_in_price - НДС включен в цену
                                // nds_not_in_price - НДС не включен в цену


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('purchases')) return;
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases','nds_rate_id')) {
                $table->dropColumn('nds_rate_id');
            }
            if (Schema::hasColumn('purchases','summ')) {
                $table->dropColumn('summ');
            }
            if (Schema::hasColumn('purchases','summ_nds')) {
                $table->dropColumn('summ_nds');
            }
            if (Schema::hasColumn('purchases','count')) {
                $table->dropColumn('count');
            }
            if (Schema::hasColumn('purchases','nds_type')) {
                $table->dropColumn('nds_type');
            }
        });
    }
};
