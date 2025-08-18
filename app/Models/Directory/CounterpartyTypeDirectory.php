<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

  
// Вид контрагента
class CounterpartyTypeDirectory extends Model
{
    protected $table = 'directory_counterparty_type';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
