<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

  
// Тип покупки

class PurchaseTypeDirectory extends Model
{
    protected $table = 'directory_purchase_types';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
