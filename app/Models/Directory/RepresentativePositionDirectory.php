<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;


// Должность представителя
class RepresentativePositionDirectory extends Model
{
    protected $table = 'directory_position_representatives';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
