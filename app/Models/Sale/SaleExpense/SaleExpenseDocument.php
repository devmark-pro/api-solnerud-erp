<?php

namespace App\Models\Sale\SaleExpense;

use App\Services\Sale\SaleExpense\SaleExpenseDocument\SaleExpenseDocumentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleExpense;


#[ObservedBy([SaleExpenseDocumentObserver::class])]
class SaleExpenseDocument extends Model
{
    protected $fillable = [
        'id',
        'name',
        'date',
        'user_id',
        'file',
        'sale_id',
        'sale_expense_id',
        'deleted_at',
    ];

    protected $hidden =[
        'file',
    ];

    protected $appends = [
        'is_file_added',
    ];

    public function saleExpense(): BelongsTo 
    {
        return $this->belongsTo(SaleExpense::class);
    }
    
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }

    public function getIsFileAddedAttribute() 
    {
        return (bool)$this->file;
    }
}

