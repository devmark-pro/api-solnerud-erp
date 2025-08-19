<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Purchase extends Model
{
    // protected $table = 'directory_counterparty_type';

    protected $fillable = [
        'id',
        'status_purchase_id',
        'purchase_type_id',
        'counterparty_id',  //Поставщик
        'nomenclature_id',  //Продукт
        'client_id',
        'packing_type_id',  // Тип фасовки
        'delivery_method_id', // способ доставки
        'price',            //цена за тонну
        'count_plan',       //количество план
                            //адрес отгрузки
        'comment', 
        'created_at',
        'deleted_at',
    ];
}
