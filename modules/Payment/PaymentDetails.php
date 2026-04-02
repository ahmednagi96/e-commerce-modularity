<?php 

namespace Modules\Payment;

readonly class PaymentDetails
{
    public function __construct(
        public string $token,
        public float $amountInCents,
        public string $statementDescription,
    ) {}
}