<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Тип фасовки
class PackingTypeDirectory extends Model
{
    protected $table = 'directory_packing_types';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
