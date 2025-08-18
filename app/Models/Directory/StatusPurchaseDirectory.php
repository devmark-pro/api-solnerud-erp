<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Статус покупки
class StatusPurchaseDirectory extends Model
{
    protected $table = 'directory_status_purchases';

    protected $fillable = [
        'id',
        'name',
        'color',
        'deleted_at',
    ];
}
