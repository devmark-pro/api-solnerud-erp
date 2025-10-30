<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\User\User;
use App\Models\Directory\WarehouseDirectory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Services\Purchase\PurchaseReceipt\PurchaseReceiptObserver;

// Поступления
#[ObservedBy([PurchaseReceiptObserver::class])]
class PurchaseReceipt extends Model
{
    protected $fillable = [
        'id',
        'dispatch_date',    // Отправка дата
        'arrival_date',     // Поступление дата

        // Накладная от поставщика
        'invoice_supplier_number',
        'invoice_supplier_file',
        'invoice_supplier_date',

        // Накладная наша
        'invoice_our_number',
        'invoice_our_file',
        'invoice_our_date',
   
        'transport',        // Транспорт
        'address_id',       // Адрес доставки
        // 'warehouse_id',     // Склад
        'quantity',         // Количество
        'user_id',          // Ответственный
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

    public function warehouse(): BelongsTo 
    {
        return $this->belongsTo(WarehouseDirectory::class);
    }

    public function address(): BelongsTo 
    {
        return $this->belongsTo(PurchaseDeliveryAddress::class);
    }
}
