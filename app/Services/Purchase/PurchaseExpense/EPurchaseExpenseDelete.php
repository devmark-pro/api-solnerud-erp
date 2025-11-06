<?php

namespace App\Services\Purchase\PurchaseExpense;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EPurchaseExpenseDelete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
}
