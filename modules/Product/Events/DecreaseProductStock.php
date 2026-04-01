<?php

namespace Modules\Product\Events;;

use App\Events\no;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Order\Events\OrderFulfilled;
use Modules\Product\CartItem;
use Modules\Product\Warehouse\ProductStockManager;

class DecreaseProductStock
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected ProductStockManager $productStockManager
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function __invoke(OrderFulfilled $event): void
    {
          $event->cartItems->items()->each(function (CartItem $cartItem) {
            $this->productStockManager->decrement($cartItem->productDto->id, $cartItem->quantity);
        });
    }
}
