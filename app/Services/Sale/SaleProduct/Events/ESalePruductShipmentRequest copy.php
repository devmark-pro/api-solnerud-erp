<?php

namespace App\Services\Sale\SaleProduct\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ESalePruductShipmentRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
}
