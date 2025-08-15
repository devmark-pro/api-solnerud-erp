<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class DirectoryTypeFlow extends Model
{
    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
