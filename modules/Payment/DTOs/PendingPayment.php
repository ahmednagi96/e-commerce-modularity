<?php 

namespace Modules\Payment\DTOs;

use Modules\Payment\PayBuddySdk;

readonly class PendingPayment
{
    public function __construct(
        public PayBuddySdk $provider,
        public string $payementToken
    )
    {   
    }
}