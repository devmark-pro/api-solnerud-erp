<?php
namespace App\Helpers;

class Nds {
  
    // НДС  включен в цену
    // Сумма НДС = Сумма * ставку НДС / (ставка НДС + 100)
    public static function  getNdsInPrice ($summ = 0, $ndsRate = 0)  {
        $result = (float)(($summ * $ndsRate) / ($ndsRate + 100));
        return round($result, 2);
    }

    // НДС не включен в цену
    // Сумма НДС = Сумма * ставку НДС
    public static function  getNdsNotInPrice ($summ = 0, $ndsRate = 0) {
        $result = (float)(($summ * $ndsRate) / 100);
        return round($result, 2);
    }


    public static function calculateNds($summ, $ndsType,  $ndsRate) {
        if ($ndsType === "no_nds") {
            return 0;
        }

        if ($ndsType === "nds_in_price") {
            return static::getNdsInPrice($summ, $ndsRate);
        }

        if ($ndsType === "nds_not_in_price") {
            return static::getNdsNotInPrice($summ, $ndsRate);
        }
        return 0;
    }

}