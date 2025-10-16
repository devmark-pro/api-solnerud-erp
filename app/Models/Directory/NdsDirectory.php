<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;


class NdsDirectory extends Model
{
    protected $table = 'directory_nds';

    protected $fillable = [
        'id',
        'rate',
        'deleted_at',
    ];
}
