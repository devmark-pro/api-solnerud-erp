<?php

namespace App\Models\Purchase\PurchaseExpense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User\User;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseExpense;


class PurchaseExpenseDocument extends Model
{
    protected $fillable = [
        'id',
        'name',
        'date',
        'user_id',
        'file',
        'purchase_id',
        'purchase_expense_id',
        'deleted_at'
    ];

    protected $hidden =[
        'file',
    ];

    protected $appends = [
        'is_file_added',
    ];

    public function purchaseExpense(): BelongsTo 
    {
        return $this->belongsTo(PurchaseExpense::class);
    }
    
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }

    public function getIsFileAddedAttribute() 
    {
        return (bool)$this->file;
    }
}
