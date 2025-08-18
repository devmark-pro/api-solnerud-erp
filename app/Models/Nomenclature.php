<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Nomenclature extends Model
{
    protected $fillable = [
        'id',
        'name',
        'system_number',
        'deleted_at',
    ];
}
