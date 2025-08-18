<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class EmployeePositionsDirectory extends Model
{
    protected $table = 'directory_employee_positions';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
