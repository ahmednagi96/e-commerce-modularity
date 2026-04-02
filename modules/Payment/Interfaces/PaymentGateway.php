<?php 

namespace Modules\Payment\Interfaces;

use Modules\Payment\PaymentDetails;
use Modules\Payment\SuccessPayment;

interface PaymentGateway
{
    public function charge(PaymentDetails $paymentDetails):SuccessPayment;
}