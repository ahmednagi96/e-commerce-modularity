<?php 

namespace Modules\Order\Events;

use Illuminate\Support\Facades\Mail;
use Modules\Order\Mail\OrderRecieved;

class SendOrderConfirmationEmail
{
    public function __invoke(OrderFulfilled $event):void{
        Mail::to($event->userDto->email)->send(new OrderRecieved($event->orderDto->localizedTotal));
    }
}