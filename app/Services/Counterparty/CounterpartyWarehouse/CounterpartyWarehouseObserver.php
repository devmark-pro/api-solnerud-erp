<?php

namespace App\Services\Counterparty\CounterpartyWarehouse;
use App\Models\Counterparty\CounterpartyWarehouse;


class CounterpartyWarehouseObserver
{    
    public function created(CounterpartyWarehouse $counterpartyWarehouse): void
    {
       //
    }

    public function updated(CounterpartyWarehouse $counterpartyWarehouse): void
    {
        //
    }

    public function deleted(CounterpartyWarehouse $counterpartyWarehouse): void
    {
        //
    }

    public function restored(CounterpartyWarehouse $counterpartyWarehouse): void
    {
        //
    }

    public function forceDeleted(CounterpartyWarehouse $counterpartyWarehouse): void
    {
        //
    }
}
