<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Purchase extends Model
{
    // protected $table = 'directory_counterparty_type';

    protected $fillable = [
        'id',
        'status_purchase_id',
        'deleted_at',
    ];
}
