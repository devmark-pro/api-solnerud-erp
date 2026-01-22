<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

class Nomenclature extends Model
{
    protected $fillable = [
        'id',
        'name',
        'system_number',
        'deleted_at',
    ];

}
