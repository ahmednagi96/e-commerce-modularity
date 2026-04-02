<?php 

namespace Modules\Payment\DTOs;

use Modules\Payment\Interfaces\PaymentGateway;

readonly class PendingPayment
{
    public function __construct(
        public PaymentGateway  $provider,
        public string $payementToken
    )
    {   
    }
}