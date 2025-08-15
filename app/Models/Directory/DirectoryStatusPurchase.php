<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class DirectoryStatusPurchase extends Model
{
    protected $fillable = [
        'id',
        'name',
        'color',
        'deleted_at',
    ];
}
