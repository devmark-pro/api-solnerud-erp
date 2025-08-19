<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

  
// Склады

class WarehouseDirectory extends Model
{
    protected $table = 'directory_warehouses';

    protected $fillable = [
        'id',
        'name',
        'address',
        'latitude',
        'longitude',
        'warehouse_lessor',     // арендадатель склада
        'deleted_at',
    ];
}
