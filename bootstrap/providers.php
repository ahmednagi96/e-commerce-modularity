<?php

use App\Providers\AppServiceProvider;
use Modules\Order\Providers\OrderServiceProvider;
use Modules\Product\Providers\ProductServiceProvider;

return [
    AppServiceProvider::class,
    OrderServiceProvider::class,
    ProductServiceProvider::class,
];
