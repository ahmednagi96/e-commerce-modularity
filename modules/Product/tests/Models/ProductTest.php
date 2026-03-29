<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test("it is Product test", function () {
  //  $product = ProductFactory::new()->create();
   $product=Product::Factory()->create();
  //
 //  $product->price_in_cents
   //
});