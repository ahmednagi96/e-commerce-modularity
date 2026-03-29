<?php

namespace Modules\Order\Actions;

use Illuminate\Database\DatabaseManager;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderLine;
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
        //chrage
        $chrage = $this->chargeAction->handle($paymentProvider, $paymentToken, $orderTotal);



        $order = $this->databaseManager->transaction(function () use ($chrage, $orderTotal, $userID, $items) {
            /** order module */
            /** @var CreatePaymentForOrder  $createPayment */
            $newOrder = Order::query()->create([
                "payment_id" => $chrage["id"],
                "payment_method" => "payBubble",
                "status" => "paid",
                "total_in_cents" => $orderTotal,
                "user_id" => $userID,
            ]);


            $payment = $this->createPayment->handle(paymentId: $chrage["id"], orderTotal: $orderTotal, userID: $userID, orderId: $newOrder->id);

            // drecease stock after create order
            $items->items()->each(function (CartItem $cartItem) {
                $this->productStockManager->decrement($cartItem->productDto->id, $cartItem->quantity);
            });


            //create order_lines
            $orderLinesData = $items->items()->map(function (CartItem $cartItem) use ($newOrder) {
                return [
                    "product_id" => $cartItem->productDto->id,
                    "order_id" => $newOrder->id,
                    "product_price_in_cents" => $cartItem->productDto->priceInCents,
                    "quantity" => $cartItem->quantity,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            })->toArray();
            OrderLine::insert($orderLinesData);
            return $newOrder;
        });
        return $order;
    }
}
