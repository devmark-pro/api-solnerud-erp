<?php

namespace App\Services\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseReceipt;
use Illuminate\Support\Facades\Log;



class PurchaseReceiptObserver
{
    /**
     * Handle the PurchaseReceipt "created" event.
     */
    public function created(PurchaseReceipt $purchaseReceipt): void
    {
        $data = [
            'address_id' => $purchaseReceipt->getAttribute('address_id'),
            'purchase_id' => $purchaseReceipt->getAttribute('purchase_id'),
        ];
        EPurchaseReceiptUpdateQuantity::dispatch($data);
    }

    /**
     * Handle the PurchaseReceipt "updated" event.
     */
    public function updated(PurchaseReceipt $purchaseReceipt): void
    {
        if($purchaseReceipt->isDirty('quantity') || $purchaseReceipt->isDirty('deleted_at'))
        {
            $data = [
                'address_id' => $purchaseReceipt->getAttribute('address_id'),
                'purchase_id' => $purchaseReceipt->getAttribute('purchase_id'),
            ];
            // Количество обновлено
            EPurchaseReceiptUpdateQuantity::dispatch($data);
        }
    }

    /**
     * Handle the PurchaseReceipt "deleted" event.
     */
    public function deleted(PurchaseReceipt $purchaseReceipt): void
    {
        //
    }

    /**
     * Handle the PurchaseReceipt "restored" event.
     */
    public function restored(PurchaseReceipt $purchaseReceipt): void
    {
        //
    }

    /**
     * Handle the PurchaseReceipt "force deleted" event.
     */
    public function forceDeleted(PurchaseReceipt $purchaseReceipt): void
    {
        //
    }
}
