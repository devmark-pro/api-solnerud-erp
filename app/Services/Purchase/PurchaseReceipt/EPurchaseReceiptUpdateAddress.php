<?php

namespace App\Services\Purchase\PurchaseReceipt;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EPurchaseReceiptUpdateAddress
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
}
