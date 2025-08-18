<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Counterparty extends Model
{
    protected $fillable = [
        'id',
        'system_number', // номер в системе
        'name',
        'counterparty_type_id', // вид контрагента
        'inn',
        'city',
        'address',
                        // Предстовитель
        'deleted_at',
    ];
}
