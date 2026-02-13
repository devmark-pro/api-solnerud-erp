<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleProduct\SaleProduct;


class SaleExpenseHelpers
{
    public static function calculateCost(
        $summ = 0, 
        $quantity=0, 
        $saleProductIds=[], 
        $includeInCost=false, 
        &$formula="" ) { 
        try {

            if(!$includeInCost) {
                return 0;
            }
            $formula="";

            $saleProducts = SaleProduct::select('id', 'shipped')
                ->where(['deleted_at' => null])
                ->whereIn('id', $saleProductIds)->get()->toArray();

            $summPr = 0;
            ///
                $summPrStr = "";
                $prIdStr="";
            //
            foreach($saleProducts as $pr) {
                if(array_key_exists('shipped', $pr)){
                    ///
                        $prIdStr .= "+Отгрузки.Товар".$pr['id'].".Отружено";
                        $summPrStr .= " +".$pr['shipped'];
                    //
                    $summPr += $pr['shipped'];
                }
            }

            $costStr = "";  
            if(!$summPr || !$quantity) {
                $costStr = "Сумма отгрузок = ".$summPr.", Расходы.количество = ".$quantity;
                $cost = 0;
            } else {
                $costStr = "(".$summ." * ". $quantity." / (".$summPrStr.")) / ". $quantity;
                $cost = round(($summ * $quantity / $summPr) / $quantity, 2);
            }

            $formula = "(Расход.Cумма * Расход.Количество / ($prIdStr)) / Расходы.Количество:</br>   ".$costStr."";
            return (float)$cost;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}

?>