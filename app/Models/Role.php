<?php

namespace App\Models;

use App\Services\Role\RoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy([RoleObserver::class])]
class Role extends Model
{
    protected $fillable = [
        'id',
        'name',
        'purchase_c',
        'purchase_r',
        'purchase_u',
        'purchase_d',

        'sale_c',
        'sale_r',
        'sale_u',
        'sale_d',

        'warehouse_remains_c',
        'warehouse_remains_r',
        'warehouse_remains_u',
        'warehouse_remains_d',

        'nomenclature_c',
        'nomenclature_r',
        'nomenclature_u',
        'nomenclature_d',

        'warehouse_c',
        'warehouse_r',
        'warehouse_u',
        'warehouse_d',
  
        'counterparty_c',
        'counterparty_r',
        'counterparty_u',
        'counterparty_d',
               
        'client_c',
        'client_r',
        'client_u',
        'client_d',

        'user_c',
        'user_r',
        'user_u',
        'user_d',

        'role_c',
        'role_r',
        'role_u',
        'role_d',

        'expense_c',
        'expense_r',
        'expense_u',
        'expense_d',

        'directory_c',
        'directory_r',
        'directory_u',
        'directory_d',
         
        'user_id',   
        'deleted_at',
    ];
}
