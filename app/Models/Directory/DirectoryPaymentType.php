<?php

namespace App\Models\Directory;

use Illuminate\Database\Eloquent\Model;

class DirectoryPaymentType extends Model
{
    protected $fillable = [
        'id',
        'name',
        'deleted_at',
    ];
}
