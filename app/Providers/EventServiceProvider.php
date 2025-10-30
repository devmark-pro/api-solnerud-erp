<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Events\PurchaseEvent;
use Illuminate\Support\Facades\Event;
use App\Services\Purchase\PurchaseReceipt\PurchaseReceiptUpdateQuantityEvent;
use App\Services\Purchase\PurchaseDeliveryAddress\PurchaseDeliveryAddressListener;

use App\Services\Purchase\Purchase\PurchaseListener;
use App\Services\Purchase\PurchaseDeliveryAddress\PurchaseDeliveryAddressUpdateActualQuantityEvent;



class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Event::listen(
            PurchaseReceiptUpdateQuantityEvent::class,
            [
                PurchaseDeliveryAddressListener::class, 'updateQuantuty',
            ],
            [
                PurchaseListener::class, 'handle'
            ]
        );
        Event::listen(
            PurchaseReceiptUpdateQuantityEvent::class,
            [
                PurchaseListener::class, 'handle'
            ]
        );

        // Event::listen(
        //     PurchaseDeliveryAddressUpdateActualQuantityEvent::class,
        //     [PurchaseListener::class, 'handle']
        // );
    }
}
