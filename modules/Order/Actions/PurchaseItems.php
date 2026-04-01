<?php

namespace Modules\Order\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Events\OrderFulfilled;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\ChargeAction;
use Modules\Payment\Actions\CreatePaymentForOrder;
use Modules\Payment\PayBuddySdk;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems
{

    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrder $createPayment,
        protected ChargeAction $chargeAction,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $events,
    ) {}

    public function handle(CartItemCollection $items, PayBuddySdk $paymentProvider, string $paymentToken, int $userID, string $userEmail): Order
    {

        $order = $this->databaseManager->transaction(function () use ($userID, $items, $paymentProvider, $paymentToken) {
            $newOrder = Order::startForUser($userID);
            $newOrder->addOrderLinesFromCartItems($items);
            $newOrder->fulfill();
            $chrage = $this->chargeAction->handle($paymentProvider, $paymentToken, $newOrder->total_in_cents);
            $this->createPayment->handle(paymentId: $chrage["id"], orderTotal: $newOrder->total_in_cents, userID: $userID, orderId: $newOrder->id);
            return $newOrder;
        });
        $this->events->dispatch(new OrderFulfilled(
            userEmail: $userEmail,
            orderId: $order->id,
            userId: $userID,
            totalInCents: $order->total_in_cents,
            localizedTotal: $order->localizedTotal(),
            cartItems: $items
        ));
        return $order;
    }
}
