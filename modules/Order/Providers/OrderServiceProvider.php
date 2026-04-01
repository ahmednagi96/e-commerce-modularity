<?php

namespace Modules\Order\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Order\Events\OrderFulfilled;
use Modules\Order\Events\SendOrderConfirmationEmail;
use Modules\Product\Events\DecreaseProductStock;

class OrderServiceProvider extends ServiceProvider
{



    public function boot():void{
       $this->loadMigrationsFrom(__DIR__."/../database/migrations");
       $this->mergeConfigFrom(__DIR__."/../config.php","order");
       Event::listen(
        OrderFulfilled::class,
        SendOrderConfirmationEmail::class
    );
    
    Event::listen(
        OrderFulfilled::class,
        DecreaseProductStock::class
    );
    
    }
}