<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;
use Modules\Order\Models\Order;

Route::get("/order-list", fn () => "order-list");

Route::middleware("auth")->group(function () {
    Route::post("check-user-products",CheckoutController::class)->name("check-user-products");
    Route::get("/{order:id}",function(Order $order){
        return $order;
    })->name("show");
});
