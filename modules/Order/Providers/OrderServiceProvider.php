<?php

namespace Modules\Order\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Order\Events\OrderFulfilled;
use Modules\Order\Events\SendOrderConfirmationEmail;
#use Modules\Order\ViewComponents\OrderLine;
use Modules\Product\Events\DecreaseProductStock;

class OrderServiceProvider extends ServiceProvider
{



    public function boot():void{
       $this->loadMigrationsFrom(__DIR__."/../database/migrations");
       $this->mergeConfigFrom(__DIR__."/../config.php","order");
       $this->loadViewsFrom(__DIR__."/../Views","order");
      // Blade::anonymousComponentPath(__DIR__."/../Views/components","order");
       //Blade::component("order-test",OrderLine::class);//
       Blade::componentNamespace("Modules\\Order\\ViewComponents","order");
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