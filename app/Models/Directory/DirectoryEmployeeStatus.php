<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class DirectoryEmployeeStatus extends Model
{
    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
