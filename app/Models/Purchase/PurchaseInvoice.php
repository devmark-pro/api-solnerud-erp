<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;
use App\Models\User;


class PurchaseInvoice extends Model
{
    protected $fillable = [
        'id',
        'number',
        'date',
        'summ',
        'summ_nds',
        'user_id',
        'file',
        'purchase_id',
        'deleted_at',
    ];

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

}

