<?php 


namespace Modules\Payment\Actions;

use Modules\Payment\Models\Payment;

class CreatePaymentForOrder
{
    public function handle(
        string $paymentId,
        int $orderId,
        int $userID,
        float $orderTotal
    ):Payment{
        /** create payment data */
        $Payment=Payment::query()->create([
            "payment_id"=>$paymentId,
            "payment_gateway"=>"payBubble",
            "status"=>"paid",
            "total_in_cents"=>$orderTotal,
            "user_id"=>$userID,
            "order_id"=>$orderId
        ]);
        return $Payment;
    }
}