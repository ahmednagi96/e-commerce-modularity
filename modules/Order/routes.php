<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;

Route::get("/order-list", fn () => "order-list");

Route::post("check-user-products",CheckoutController::class)->name("check-user-products")->middleware("auth");