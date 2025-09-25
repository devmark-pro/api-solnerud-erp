<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User\User;
  
// Склады

class Warehouse extends Model
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
