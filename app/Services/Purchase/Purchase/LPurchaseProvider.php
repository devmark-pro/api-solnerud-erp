<?php

namespace App\Services\Purchase\Purchase;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\Purchase;

use App\Services\Directory\Nds\NdsService;
use App\Helpers\Nds; 
use App\Services\Purchase\PurchaseReceipt\EPurchaseReceiptUpdateQuantity;

use Illuminate\Support\Facades\Log;


class LPurchaseProvider extends ServiceProvider
{
  

    public function boot(): void
    {
        Event::listen(
            EPurchaseReceiptUpdateQuantity::class,
            [$this, 'calculateQuantity'],
        );

    }
    public function calculateQuantity(object $event): void
    {

        if(!array_key_exists('purchase_id', $event->data)) return;        
        $purchaseId = $event->data['purchase_id'];
        $actualQuantity = PurchaseReceipt::where([
            'purchase_id' => $purchaseId,
            'deleted_at' => null,
        ])->sum('quantity');
        
        $model = Purchase::where('id', $purchaseId)->first();   
        $price = $model->price;
        $count = $actualQuantity;
            
        $summ = $price * $count;
        $model->summ = $summ;
        $ndsRate = NdsService::getRateById($model->nds_rate_id);
        $ndsType = $model->nds_type;
        $model->summ_nds = Nds::calculateNds($summ, $ndsType,  $ndsRate);
        $model->count = $actualQuantity;
        $model->save(); 
    }
}
