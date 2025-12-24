<?php

namespace App\Services\Sale\Sale;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleProduct\Events\ESalePruductShipmentRequest;
use App\Models\Sale\Sale;
use Illuminate\Support\Facades\Log;

class LSaleProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            ESalePruductShipmentRequest::class,
            [$this, 'calculate'],
        );
        
    }

    public function calculate(object $event): void
    {
        if(!array_key_exists('sale_id', $event->data)) 
                throw new \Exception('LSaleProvider->calculate error');

            
            
            $saleId = $event->data['sale_id'];

        $total = SaleProduct::where([
                'deleted_at' => null, 
                'sale_id' => $saleId
            ])
                ->select('sale_id',
                    \DB::raw('
                        sale_id as id,
                        sum(summ) as summ, 
                        sum(quantity) as quantity,
                        sum(summ_nds) as summ_nds
                    '))
                ->groupBy('sale_id')
                ->first();

        Sale::where(['id' => $saleId])->first()->update([
          'summ' => $total->summ,
          'summ_nds' => $total->summ_nds,
          'quantity' => $total->quantity,  
        ]);
    }
    
    
}
