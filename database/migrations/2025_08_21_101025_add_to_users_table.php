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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->foreignId('employee_position_id')->nullable()->constrained('directory_employee_positions');
            $table->foreignId('employee_status_id')->nullable()->constrained('directory_employee_statuses');
            $table->foreignId('warehouse_id')->nullable()->constrained('directory_warehouses');
            $table->string('phone', 32)->nullable();
            $table->string('city')->nullable();
            $table->date('employment_date')->nullable();
            $table->date('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('patronymic');
            $table->dropColumn('employee_position_id');
            $table->dropColumn('employee_status_id');
            $table->dropColumn('warehouse_id');
            $table->dropColumn('employment_date');
            $table->dropColumn('phone');
            $table->dropColumn('city');
            $table->dropColumn('deleted_at');

        });
    }
};
