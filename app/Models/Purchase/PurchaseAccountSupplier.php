<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;
use App\Models\Directory\PaymentTypeDirectory;

// Счет поставщика
class PurchaseAccountSupplier extends Model
{
    protected $appends = [ 'formatted_summ', 'remained'];

    protected $fillable = [
        'id',
        'payment_type_id',  // Тип оплаты r
        'summ',             // r
        'summ_nds',
        'paid',             // оплачено 0        
        // 'remained',         // осталось
        'payment_data',     // срок оплаты
        'purchase_id',
        'deleted_at',
    ];
    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function paymentType(): BelongsTo 
    {
        return $this->belongsTo(PaymentTypeDirectory::class);
    }
    public function getFormattedSummAttribute() 
    {
        return $this->summ." ₽";
    }
    public function getRemainedAttribute() 
    {
        return $this->summ - $this->paid." ₽";
    }
}

