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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_request_shipment')->default(false);
            $table->foreignId('nomenclature_id')->constrained();   // товар
            $table->foreignId('packing_type_id')
                ->nullable()
                ->constrained('directory_packing_types');  
            
            $table->string('shipment_type')->nullable();    //  Со склада / С завода  R  
            $table->foreignId('purchase_id')->nullable()->constrained();
            $table->foreignId('counterparty_id')->nullable()->constrained();   // поставщик

            $table->foreignId('warehouse_id')->nullable()->constrained('directory_warehouses');       

            $table->string('delivery_address')->nullable();
            $table->float('quantity')->default(0);    // план тон
            $table->float('availability')->default(0); // Доступно
            $table->decimal('cost', 14, 2)->default(0)->nullable();
            $table->float('price')->default(0);         // цена 
            $table->decimal('summ', 14, 2)->default(0);
            $table->decimal('summ_nds', 14, 2)->default(0);
            $table->integer('nds_rate_id')->nullable()->constrained('directory_nds');  // Ставка
            $table->decimal('nds_rate', 14, 2)->default(0);  // Ставка
            $table->boolean('is_nds_in_price')->default(false);
            $table->decimal('profit', 14, 2)->default(0);  // прибыль '= Сумма - (Себестоимость * Количество (тн))
            $table->foreignId('delivery_method_id')     // способ доставки
                ->constrained('directory_delivery_methods'); 
            





            $table->date('delivery_date')->nullable(); // Срок поставки (скрыто по умолчанию)

            $table->float('shipped')->default(0);  //Отгружено (скрыто по умолчанию)
            $table->float('remains_ship')->default(0); // Осталось (скрыто по умолчанию)

            $table->decimal('shipment_summ', 14, 2)->default(0); // Сумма отгрузки (скрыто по умолчанию)
            $table->decimal('shipment_summ_nds', 14, 2)->default(0); // Сумма ндс отгрузки (скрыто по умолчанию)
            $table->boolean('shipment_is_nds_in_price')->default(false);
            $table->integer('shipment_nds_rate_id')->nullable()->constrained('directory_nds');  // Ставка
            $table->decimal('shipment_nds_rate', 14, 2)->default(0);  // Ставка
            $table->text('comment')->nullable();

            $table->foreignId('sale_id')->constrained();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_products');
    }
};
