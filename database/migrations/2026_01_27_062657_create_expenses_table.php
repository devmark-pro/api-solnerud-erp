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
        Schema::create('expenses', function (Blueprint $table) {
            
            $table->id();

       
            $table->foreignId('warehouse_id')->nullable()->constrained('directory_warehouses');       
            $table->foreignId('type_flow_id')->nullable()->constrained('directory_type_flows');   // Тип расхода
          
            $table->date('service_date_from')->nullable();   // Дата услуги
            $table->date('service_date_to')->nullable();   // Дата услуги

            $table->string('name')->nullable();
            $table->float('rate')->nullable();  // Ставка
            
            $table->string('executor_type'); // Исполнитель или контрагент  user | counterparty

            $table->foreignId('executor_user_id')->nullable()
                ->constrained('users');     // Исполнитель сотрудник

            $table->foreignId('executor_counterparty_id')->nullable()
                ->constrained('counterparties');     // Исполнитель контрагент
           

            $table->integer('nds_rate_id')->nullable()->constrained('directory_nds');  // Ставка
            $table->decimal('nds_rate', 14, 2)->default(0);  // Ставка
            $table->boolean('is_nds_in_price')->default(false);

            $table->decimal('summ', 14, 2)->default(0)->nullable();
            $table->decimal('summ_nds', 14, 2)->default(0)->nullable();

            $table->integer('quantity')->nullable();  // Количество
            $table->boolean('include_in_cost')->default(true);     // Учет в себес.
            
            //Документы id
            // Возмещение расходов
            $table->string('reimbursement_expenses'); 
                //    'refunded',     // Возмещен
                //    'required',     // Требуется   
                //    'not_required'  // Не требуется  
                
            $table->date('reimbursement_date')->nullable(); //Дата возмещения
            $table->dateTimeTz('deleted_at')->nullable();
            $table->timestampsTz();

        });

        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('expense_c')->default(false); 
            $table->boolean('expense_r')->default(true); 
            $table->boolean('expense_u')->default(false); 
            $table->boolean('expense_d')->default(false); 
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');

        if (Schema::hasColumn('roles', 'expense_c')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('expense_c');
            });
        }
        if (Schema::hasColumn('roles', 'expense_r')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('expense_r');
            });
        }
        if (Schema::hasColumn('roles', 'expense_u')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('expense_u');
            });
        }
        if (Schema::hasColumn('roles', 'expense_d')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('expense_d');
            });
        }

    }
};
