<?php 

namespace Modules\Payment;

readonly class SuccessPayment
{
    public function __construct(
        public string $id,
        public float $amountInCents,
        public PaymentProvider $provider,
    ) {}
}