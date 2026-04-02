<?php 

namespace Modules\Payment;

enum PaymentProvider:string
{
    case PAY_BUDDY = 'pay_buddy';
    case IN_MEMORY = 'in_memory';
}