<?php 

namespace Modules\Order\Checkout;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail
{
    public function __invoke(OrderFulfilled $event):void{
        Mail::to($event->userDto->email)->send(new OrderRecieved($event->orderDto->localizedTotal));
    }
}