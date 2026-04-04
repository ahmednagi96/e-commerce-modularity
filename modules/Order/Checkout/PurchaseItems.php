<?php

namespace Modules\Order\Checkout;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Contracts\OrderDto;
use Modules\Order\Order;
use Modules\Payment\Actions\ChargeAction;
use Modules\Payment\Actions\CreatePaymentForOrder;
use Modules\Payment\DTOs\PendingPayment;
use Modules\Payment\PaymentDetails;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\User\DTOs\UserDto;

class PurchaseItems
{

    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrder $createPayment,
        protected ChargeAction $chargeAction,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $events,
    ) {}

    public function handle(CartItemCollection $items, PendingPayment $pendingPayment,UserDto $userDTO): OrderDto
    {

        $orderDto = $this->databaseManager->transaction(function () use ($userDTO, $items, $pendingPayment):OrderDto {
            $newOrder = Order::startForUser($userDTO->userId);
            $newOrder->addOrderLinesFromCartItems($items);
            $newOrder->fulfill();

            $chrage = $this->chargeAction->handle(new PaymentDetails(token:$pendingPayment->payementToken,amountInCents: $newOrder->total_in_cents,statementDescription:"laracast"));
            $this->createPayment->handle(paymentId: $chrage->id, orderTotal: $newOrder->total_in_cents, userID: $userDTO->userId, orderId: $newOrder->id,provider:$chrage->provider);
            return OrderDto::fromEloguentModel($newOrder);
        });
        $this->events->dispatch(new OrderFulfilled(
            userDto: $userDTO,
            orderDto: $orderDto,
        ));
        return $orderDto;
    }
}
