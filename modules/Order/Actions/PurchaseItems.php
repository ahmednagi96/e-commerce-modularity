<?php

namespace Modules\Order\Actions;

use Illuminate\Database\DatabaseManager;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\ChargeAction;
use Modules\Payment\Actions\CreatePaymentForOrder;
use Modules\Payment\PayBuddySdk;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems
{

    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrder $createPayment,
        protected ChargeAction $chargeAction,
        protected DatabaseManager $databaseManager,
    ) {}

    public function handle(CartItemCollection $items, PayBuddySdk $paymentProvider, string $paymentToken, int $userID): Order
    {

        $orderTotal = $items->totalInCents();

        //Chrage
        $chrage = $this->chargeAction->handle($paymentProvider, $paymentToken, $orderTotal);

        $order = $this->databaseManager->transaction(function () use ($chrage, $orderTotal, $userID, $items) {
            $newOrder=Order::startForUser($userID);
            $newOrder->addOrderLinesFromCartItems($items);
            $newOrder->fulfill();
           
            // drecease stock after create order
            $items->items()->each(function (CartItem $cartItem) {
                $this->productStockManager->decrement($cartItem->productDto->id, $cartItem->quantity);
            });
            $this->createPayment->handle(paymentId: $chrage["id"], orderTotal: $orderTotal, userID: $userID, orderId: $newOrder->id);
            return $newOrder;
        });
        return $order;
    }
}
