<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
  
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
        'user_id',
        'warehouse_lessor',     // арендадатель склада
        'deleted_at',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}
