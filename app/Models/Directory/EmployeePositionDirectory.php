<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Должность сотрудника
class EmployeePositionDirectory extends Model
{
    protected $table = 'directory_employee_positions';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
