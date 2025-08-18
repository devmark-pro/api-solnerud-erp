<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

// Статус сотрудника
class EmployeeStatusDirectory extends Model
{
    protected $table = 'directory_employee_statuses';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
