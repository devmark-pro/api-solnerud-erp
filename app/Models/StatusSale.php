<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusSale extends Model
{
    protected $fillable = [
        'id',
        'code',
        'name',
        'color',
        'deleted_at',
    ];
}
