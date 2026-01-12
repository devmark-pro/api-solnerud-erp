<?php

namespace App\Services\Client\ClientWarehouse;
use App\Models\Client\ClientWarehouse;


class ClientWarehouseObserver
{    
    public function created(ClientWarehouse $clientWarehouse): void
    {
       //
    }

    public function updated(ClientWarehouse $clientWarehouse): void
    {
        //
    }

    public function deleted(ClientWarehouse $clientWarehouse): void
    {
        //
    }

    public function restored(ClientWarehouse $clientWarehouse): void
    {
        //
    }

    public function forceDeleted(ClientWarehouse $clientWarehouse): void
    {
        //
    }
}
