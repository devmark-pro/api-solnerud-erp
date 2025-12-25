<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleProduct\SaleProduct;


class SaleExpenseHelpers
{
    public static function calculateCost($summ = 0, $quantity=0, $saleProductIds=[], $includeInCost=false){ 
        try {

            if(!$includeInCost) {
                return 0;
            }

            $saleProducts = SaleProduct::select('id', 'shipped')
                ->whereIn('id', $saleProductIds)->get()->toArray();

            $summPr = 0;

            foreach($saleProducts as $pr){
                if(array_key_exists('shipped',$pr)){
                    $summPr += $pr['shipped'];
                }
            }

            if(!$summPr || !$quantity) {
                $cost = 0;
            } else {
                $cost = round(($summ * $quantity / $summPr) / $quantity, 2);
            }
            return (float)$cost;

        } catch (\Exception $e) {
            return $e->getMessage();
        }   

    }

}

?>