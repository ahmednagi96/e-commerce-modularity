<?php 

namespace Modules\Order\Events;

use Illuminate\Support\Facades\Mail;
use Modules\Order\Mail\OrderRecieved;

class SendOrderConfirmationEmail
{
    public function __invoke(OrderFulfilled $event):void{
        Mail::to($event->userEmail)->send(new OrderRecieved($event->localizedTotal));
    }
}