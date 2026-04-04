<?php

namespace Modules\Product\Events;;

use Modules\Order\Checkout\OrderFulfilled;
use Modules\Order\Contracts\OrderLinesDto;
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
         $event->orderDto->lines->each(function (OrderLinesDto $orderLines) {
            $this->productStockManager->decrement($orderLines->productId, $orderLines->quantity);
        });
    }
}
