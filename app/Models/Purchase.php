<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Purchase extends Model
{
    // protected $table = 'directory_counterparty_type';

    protected $fillable = [
        'id',
        'status_purchase_id',
        'purchase_types_id',
        'counterparty_id',  //Поставщик

        'deleted_at',
    ];
}
