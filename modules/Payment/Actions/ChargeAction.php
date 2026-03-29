<?php 

namespace Modules\Payment\Actions;

use Modules\Payment\PayBuddySdk;

class ChargeAction{
    public function handle(PayBuddySdk $payBuddySdk,string $paymentToken,float $orderTotal):array{
        $charge=$payBuddySdk->charge($paymentToken,$orderTotal,"charge for order"); 
        return $charge;
    }
}