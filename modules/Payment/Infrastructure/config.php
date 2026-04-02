<?php

use Modules\Payment\InMemortGateway;
use Modules\Payment\PayBuddyGateway;

return [
    "payment_providers"=>[
        "pay_buddy"=>PayBuddyGateway::class,
        "in_memory"=>InMemortGateway::class
    ],
    'provider' => env('PAYMENT_PROVIDER', 'pay_buddy'),
];