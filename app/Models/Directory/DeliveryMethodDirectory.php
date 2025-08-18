<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Способ доставки
class DeliveryMethodDirectory extends Model
{
    protected $table = 'directory_delivery_methods';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
