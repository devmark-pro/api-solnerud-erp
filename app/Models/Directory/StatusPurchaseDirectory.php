<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

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
