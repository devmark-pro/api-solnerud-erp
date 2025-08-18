<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Статус продажи
class StatusSaleDirectory extends Model
{
    protected $table = 'directory_status_sales';

    protected $fillable = [
        'id',
        'name',
        'color',
        'deleted_at',
    ];
}
