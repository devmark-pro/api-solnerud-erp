<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Services\Purchase\Purchase\EPurchaseUpdatePrice;

use Illuminate\Support\Facades\Log;
use App\Models\Purchase\PurchaseExpense\PurchaseExpense;
use App\Services\Purchase\PurchaseExpense\EPurchaseExpenseUpdateSumm;
use App\Services\Purchase\PurchaseExpense\EPurchaseExpenseCreate;
use App\Services\Purchase\PurchaseExpense\EPurchaseExpenseDelete;
use App\Services\Purchase\PurchaseExpense\EPurchaseExpenseIncludeInCost;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseAddress\EPurchaseExpenseDeleteAddress;


class LPurchaseDeliveryAddressCalculateCostProvider extends ServiceProvider
{
    private $purchaseExpenseSumm;
    private $deliveryAddressActualQuantity;
    private $purchaseExpenseCurrentAdresses;
    private $puchasePrice;

    public function boot(): void
    {
        Event::listen(
            EPurchaseExpenseUpdateSumm::class,
            [$this, 'calculateCostForAllAddresses']
        );
        Event::listen(
            EPurchaseExpenseDelete::class,
            [$this, 'calculateCostForAllAddresses']
        );
        Event::listen(
            EPurchaseUpdatePrice::class,
            [$this, 'calculateCostForAllAddresses']
        );
        Event::listen(
            EPurchaseExpenseDeleteAddress::class,
            [$this, 'calculateCostForAllAddresses']
        );
        Event::listen(
            EPurchaseExpenseCreate::class,
            [$this, 'calculateCostForAllAddresses']
        );
        Event::listen(
            EPurchaseExpenseIncludeInCost::class,
            [$this, 'calculateCostForAllAddresses']
        );

        
    }
   
    
    // Пересчет себестоимости для необходимых адресов
    public function calculateCost(object $event): void
    {
        
        if(!array_key_exists('purchase_id', $event->data) || 
            !array_key_exists('purchase_expense_id', $event->data)) return;        
        $purchaseId = $event->data['purchase_id'];     
        $purchaseExpenseId = $event->data['purchase_expense_id'];

        $this->initCost($purchaseId);
        $addresses = $this->purchaseExpenseAdresses[$purchaseExpenseId];

        /* 
            1. Обновление Расходы
            2. Узнать Адреса и Фактическое количестов по Адресам
            3. Расчитать Сумму Расход и Фактическое количестов по Адресам
            4. Расчитать общую сумму
        */
      
        $costs = $this->getCosts($addresses);
     
        $this->updateCosts($costs);
    }

    // Пересчет себестоимости для всех адресов
    public function calculateCostForAllAddresses(object $event): void
    {
        if(!array_key_exists('purchase_id', $event->data)) return;           
        $purchaseId = $event->data['purchase_id'];
        $addresses = PurchaseDeliveryAddress::select('id')->
            where([
                'purchase_id' => $purchaseId,
                'deleted_at' => null
            ])->pluck('id')->toArray();

        $this->initCost($purchaseId);
        $costs = $this->getCosts($addresses);
        $this->updateCosts($costs);
    }

    private function initCost($purchaseId){
        
        $this->puchasePrice = Purchase::where(['id'=>$purchaseId])->first()->price;

        $this->deliveryAddressActualQuantity = PurchaseDeliveryAddress::
            select(['id', 'actual_quantity'])
            ->where([
                'purchase_id'=>$purchaseId,
                'deleted_at' => null
            ])->get()
            ->pluck('actual_quantity','id')
            ->toArray();


        $purchaseExpense = PurchaseExpense::
            where([
                'purchase_id' => $purchaseId,
                'include_in_cost' => true,
                'deleted_at' => null
            ])->get();

        $this->purchaseExpenseSumm = $purchaseExpense
            ->pluck('summ','id')
            ->toArray();

        $this->purchaseExpenseAdresses = $purchaseExpense
            ->pluck('addresses','id')
            ->toArray();

        foreach ($this->purchaseExpenseAdresses as  &$item) 
        {
            foreach ($item as  &$item1) {
                $item1 = $item1['address_id'];
            }
        }
    }

    // Расчет сусммы Расходов
    private function purchaseExpenseSumm($purchaseExpenseId, $addressId) {
        $purchaseExpenseCurrentSumm = (int)$this->purchaseExpenseSumm[$purchaseExpenseId];
        $actualQuantity = (int)$this->deliveryAddressActualQuantity[$addressId];
    
        $purchaseExpenseCurrentAdressesArr = $this->purchaseExpenseCurrentAdresses[$purchaseExpenseId];
        $summAdr = 0;
        foreach($purchaseExpenseCurrentAdressesArr as $addrId){
            $summAdr += (int)$this->deliveryAddressActualQuantity[$addrId];
        }
        if($purchaseExpenseCurrentSumm === 0 || $actualQuantity ===0 ||$summAdr === 0) return 0;
        return  round($purchaseExpenseCurrentSumm / $summAdr * $actualQuantity / $summAdr, 2);
    }


    private function getCosts($addresses){
        $cost = [];
        foreach($addresses as $addressId) 
        {
            $this->purchaseExpenseCurrentAdresses = [];
            foreach ($this->purchaseExpenseAdresses as $key => $item3){
                if(in_array($addressId, $item3)){
                    $this->purchaseExpenseCurrentAdresses[$key] = $item3;
                }
            }
            unset($item3);
            $summ = 0;
            foreach($this->purchaseExpenseCurrentAdresses as $purchaseExpenseId => $item) { 
                $summ += $this->purchaseExpenseSumm($purchaseExpenseId, $addressId);
            }

            $cost[$addressId] = $summ;
        }
        return $cost;
    }

    private function updateCosts($costs){
        foreach($costs as $id => $addressSumm){
            PurchaseDeliveryAddress::where([
                'id'=>$id
            ])
            ->first()
            ->update(['cost' => $addressSumm + $this->puchasePrice ]);
        }
    }
}
