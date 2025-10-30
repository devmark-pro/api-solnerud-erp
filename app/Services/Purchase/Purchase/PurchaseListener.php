<?php

namespace App\Services\Purchase\Purchase;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\Purchase;

use App\Services\Directory\Nds\NdsService;
use App\Helpers\Nds; 


use Illuminate\Support\Facades\Log;


class PurchaseListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if(!array_key_exists('purchase_id', $event->data)) return;        
        $purchaseId = $event->data['purchase_id'];
        $actualQuantity = PurchaseReceipt::where([
            'purchase_id' => $purchaseId,
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
