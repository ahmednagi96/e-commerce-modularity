<?php 

namespace Modules\Payment\Actions;

use Modules\Payment\Interfaces\PaymentGateway;
use Modules\Payment\PaymentDetails;
use Modules\Payment\SuccessPayment;

class ChargeAction{

    public function __construct(public PaymentGateway $paymentGateway)
    {}
    public function handle(PaymentDetails $paymentDetails):SuccessPayment{
        $charge=$this->paymentGateway->charge($paymentDetails); 
       // dd($charge);
        return $charge;
    }
}