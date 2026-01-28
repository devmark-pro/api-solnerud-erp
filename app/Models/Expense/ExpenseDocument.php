<?php

namespace App\Models\Expense;

use App\Services\Expense\ExpenseDocument\ExpenseDocumentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy([ExpenseDocumentObserver::class])]
class ExpenseDocument extends Model
{
      protected $fillable = [
        'id',
        'name',
        'date',
        'user_id',
        'file',
        'expense_id',
        'deleted_at'
    ];

    protected $hidden = [
        'file',
    ];

    protected $appends = [
        'is_file_added',
    ];

    public function expense(): BelongsTo 
    {
        return $this->belongsTo(Expense::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsFileAddedAttribute() 
    {
        return (bool)$this->file;
    }

}

