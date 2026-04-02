<?php 


namespace Modules\Payment\Actions;

use Modules\Payment\Models\Payment;
use Modules\Payment\PaymentProvider;

class CreatePaymentForOrder
{
    public function handle(
        string $paymentId,
        int $orderId,
        int $userID,
        float $orderTotal,
        PaymentProvider $provider
    ):Payment{
        /** create payment data */
        $Payment=Payment::query()->create([
            "payment_id"=>$paymentId,
            "payment_gateway"=>$provider,
            "status"=>"paid",
            "total_in_cents"=>$orderTotal,
            "user_id"=>$userID,
            "order_id"=>$orderId
        ]);
        return $Payment;
    }
}