<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;

class PurchaseDocument extends Model
{
    protected $fillable = [
        'id',
        'date',     
        'name',
        'file',
        'user_id',
        'comment',
        'purchase_id',
        'deleted_at',
    ];

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
}
