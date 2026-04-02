<?php 

namespace Modules\Payment;

use Modules\Payment\Interfaces\PaymentGateway;

class PayBuddyGateway implements PaymentGateway
{
    public function __construct(
        private PayBuddySdk $payBuddySdk,
    ) {}

     /** @param  paymentDetails $paymentDetails*/
    /** @return SuccessPayment */
    public function charge(PaymentDetails $paymentDetails): SuccessPayment
    {
        $charge=$this->payBuddySdk->charge(
            token: $paymentDetails->token,
            amountInCents: $paymentDetails->amountInCents,
            statementDescription: $paymentDetails->statementDescription
        );

        return new SuccessPayment( id: $charge["id"],amountInCents: $charge["amount_in_cents"],provider: $this->provider());
    }

     /** @return PaymentProvider */
    public function provider(): PaymentProvider
    {
        return PaymentProvider::PAY_BUDDY;
    }
}