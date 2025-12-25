<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Sale\SaleProduct\SaleProduct;
use Illuminate\Support\Facades\Log;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;
// use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;
// use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpense;
// use App\Services\Sale\SaleProduct\Events\ESalePruductShippedUpdate;
use App\Services\Sale\SaleExpense\SaleExpense\SaleExpenseHelpers;
use App\Models\Sale\SaleExpense\SaleExpenseProduct;
use App\Models\Sale\SaleExpense\SaleExpense;


class LSaleExpenseProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            ESaleShipped::class,
            [$this, 'calculateCost'],
        );
        // Event::listen(
        //     ESalePruductShippedUpdate::class,
        //     [$this, 'calculateCostAfterUpdateTotalQuantity'],
        // );
        
    }

    public function calculateCost(object $event): void
    {
       if(!array_key_exists('sale_product_id', $event->data))
        throw new \Exception('LSaleExpenseProvider->calculateCost error');

        $saleProductId = $event->data['sale_product_id'];

        $saleExpenseIds = SaleExpenseProduct::select('sale_expense_id')
            ->where(['sale_product_id'=>$saleProductId])
            ->get()->pluck('sale_expense_id');

        if(count($saleExpenseIds) < 1) return;

        $saleExpenseProductIds = SaleExpenseProduct::select('sale_expense_id','sale_product_id')
            ->whereIn('sale_expense_id', $saleExpenseIds)
            ->get()->toArray();

        if(count($saleExpenseProductIds) < 1) return;

        $saleExpenseProducts = []; 
        $saleExpenseIds = [];
        foreach($saleExpenseProductIds as  $saleExpenseProduct){
            if(!in_array($saleExpenseProduct['sale_expense_id'], $saleExpenseIds)){
                $saleExpenseIds[] = $saleExpenseProduct['sale_expense_id'];
            }
            $saleExpenseProducts[$saleExpenseProduct['sale_expense_id']][] = $saleExpenseProduct['sale_product_id'];
        }

        if(count($saleExpenseIds) < 1) return;

        $saleExpenses = SaleExpense::select('id', 'summ', 'quantity', 'include_in_cost')
            ->whereIn('id',$saleExpenseIds)->get()->toArray();

        foreach($saleExpenses as $expenses){
            if (
                !array_key_exists('id', $expenses) ||
                !array_key_exists('summ', $expenses) ||
                !array_key_exists('quantity', $expenses) ||
                !array_key_exists('include_in_cost', $expenses) ||
                !array_key_exists($expenses['id'], $saleExpenseProducts) 
                ) return;

            $cost = SaleExpenseHelpers::calculateCost(
                $expenses['summ'], 
                $expenses['quantity'], 
                $saleExpenseProducts[$expenses['id']], 
                $expenses['include_in_cost']
            );
            SaleExpense::where(['id'=>$expenses['id']])
                ->first()->update(['cost'=>$cost]);

        }
    }
}
