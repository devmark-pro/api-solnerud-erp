<?php
namespace App\Helpers;

class Nds {
  
    // НДС  включен в цену
    // Сумма НДС = Сумма * ставку НДС / (ставка НДС + 100)
    public static function  getNdsInPrice ($summ = 0, $ndsRate = 0)  {
        $result = (float)(((float)$summ * (float)$ndsRate) / ($ndsRate + 100));
        return round($result, 2);
    }

    // НДС не включен в цену
    // Сумма НДС = Сумма * ставку НДС
    public static function  getNdsNotInPrice ($summ = 0, $ndsRate = 0) {
        $result = (float)(((float)$summ * (float)$ndsRate) / 100);
        return round($result, 2);
    }

    

    public static function calculateNds($summ, $isNdsInPrice,  $ndsRate) {

        if ($isNdsInPrice) {
            return static::getNdsInPrice($summ, $ndsRate);
        }
        return static::getNdsNotInPrice($summ, $ndsRate);
    }

}