<?php 

namespace Modules\Payment\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Payment\Interfaces\PaymentGateway;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        $this->mergeConfigFrom(__DIR__."/../config.php","payment");
        $providerKey   = config('payment.provider');
        $providerClass = config("payment.payment_providers.$providerKey");
        $this->app->bind(PaymentGateway::class, $providerClass);
    }
    
}