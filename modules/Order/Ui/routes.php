<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Checkout\CheckoutController;
use Modules\Order\Order;

Route::get("/order-list", fn () => "order-list");

Route::middleware("auth")->group(function () {
    Route::post("check-user-products",CheckoutController::class)->name("check-user-products");
    Route::get("/{order:id}",function(Order $order){
        return $order;
    })->name("show");
});
