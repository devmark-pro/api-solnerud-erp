<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class DirectoryEmployeePositions extends Model
{
    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
