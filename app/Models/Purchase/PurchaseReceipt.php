<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;
use App\Models\User;
use App\Models\Directory\WarehouseDirectory;



// Поступления
class PurchaseReceipt extends Model
{
    protected $fillable = [
        'id',
        'dispatch_date',    // Отправка дата
        'arrival_date',     // Поступление дата
        'invoice_supplier', // Накладная от поставщика
        'invoice_our',      // Накладная наша
        'transport',        // Транспорт
        'delivery_address', // Адрес доставки
        'warehouse_id',     // Склад
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
}
