<?php

use App\Providers\AppServiceProvider;
use Modules\Order\Providers\OrderServiceProvider;
use Modules\Payment\Infrastructure\Providers\PaymentServiceProvider;
use Modules\Product\Providers\ProductServiceProvider;

return [
    AppServiceProvider::class,
    OrderServiceProvider::class,
    ProductServiceProvider::class,
    PaymentServiceProvider::class,
];
