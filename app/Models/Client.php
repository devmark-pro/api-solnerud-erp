<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Client extends Model
{
    protected $fillable = [
        'id',
        'name',
        'system_number',
        'inn',
        'city',
        'address',
        'created_at',
        'deleted_at',

    ];
}
