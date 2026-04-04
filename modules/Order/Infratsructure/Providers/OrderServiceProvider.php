<?php

namespace Modules\Order\Infratsructure\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Order\Checkout\OrderFulfilled;
use Modules\Order\Checkout\SendOrderConfirmationEmail;
#use Modules\Order\Ui\ViewComponents\OrderLine;
use Modules\Product\Events\DecreaseProductStock;

class OrderServiceProvider extends ServiceProvider
{



    public function boot():void{
       $this->loadMigrationsFrom(__DIR__."/../database/migrations");
       $this->mergeConfigFrom(__DIR__."/../config.php","order");
       $this->loadViewsFrom(__DIR__."/../Views","order");
      // Blade::anonymousComponentPath(__DIR__."/../Views/components","order");
       //Blade::component("order-test",OrderLine::class);//
       Blade::componentNamespace("Modules\\Order\\Ui\\ViewComponents","order");
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