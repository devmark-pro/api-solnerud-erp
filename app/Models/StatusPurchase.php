<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPurchase extends Model
{
    protected $fillable = [
        'id',
        'name',
        'color',
        'deleted_at',
    ];
}
