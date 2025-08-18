<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Тип расхода
class TypeFlowDirectory extends Model
{
    protected $table = 'directory_type_flows';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
