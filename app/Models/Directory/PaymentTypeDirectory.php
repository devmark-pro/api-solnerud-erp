<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class PaymentTypeDirectory extends Model
{
    protected $table = 'directory_payment_types';

    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
