<?php

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Order\Models\Order;
use Modules\Payment\PayBuddySdk;
use Modules\Product\Database\Factories\ProductFactory;
use Tests\TestCase;

uses(TestCase::class,RefreshDatabase::class);
test("it_successfull_creates_an_order",function(){
            //arrange

    # create user
    $user=UserFactory::new()->create();

    //cerate product 

    $products=ProductFactory::new()->count(2)->create(
        new Sequence(
            
                ["name"=>"product 1","price_in_cents"=>3000,"stock"=>10],
                ["name"=>"product 2","price_in_cents"=>1000,"stock"=>10],
            ),
    );

    //create valid tokenphp
    $paymentToken=PayBuddySdk::validToken();
    
    # act
    /** @var TestCase $this */
   $response=$this->actingAs($user)->postJson(route("order::orders.check-user-products"),[
        "payment_token"=>$paymentToken,
        "products"=>[
           0=> ["id"=>$products->first()->id,"quantity"=>1],
           1=> ["id"=>$products->last()->id,"quantity"=>1],
            ],
        ]
   );
    

   //Assert 

   $order=Order::query()->latest("id")->first();

    $response->assertStatus(201)
                ->assertJson([
                    'orderUrl'=>$order->url(),
                ]);
   
   //assert of order
    $order=Order::query()->latest("id")->first();
     $this->assertTrue($order->user()->is($user));
     $this->assertEquals(4000,$order->total_in_cents);
     $this->assertEquals("paid",$order->status);
     $this->assertEquals("payBubble",$order->payment_method);
     $this->assertEquals("36",strlen($order->payment_id));


     //Assert payment of ordre
     $payment=$order->lastPayment;

     $this->assertTrue($payment->user()->is($user));
     $this->assertEquals(4000,$payment->total_in_cents);
     $this->assertEquals("paid",$payment->status);
     $this->assertEquals("payBubble",$payment->payment_gateway);
     $this->assertEquals("36",strlen($payment->payment_id));

     //assert of order lines
     foreach($products as $product){
        $orderline=$product->lines()->where("product_id",$product->id)->first();
        $this->assertEquals("1",$orderline->quantity);
        $this->assertEquals($product->price_in_cents,$orderline->product_price_in_cents);
     }

     $products=$products->fresh();
     $this->assertEquals(9,$products->first()->stock);
     $this->assertEquals(9,$products->last()->stock);
});

test("it_fails_with_an_invalid_token",function(){

    //arrange
    $user=UserFactory::new()->create();
    $product=ProductFactory::new()->create();
    $paymentToken=PayBuddySdk::invalidToken();

    //act
      /** @var TestCase $this */
    $response=$this->actingAs($user)->postJson(route("orders.check-user-products"),[
        "payment_token"=>$paymentToken,
        "products"=>[
           0=> ["id"=>$product->id,"quantity"=>1],
            ],
        ]
   );  /** @var TestCase $this */

   //assert 
    $response->assertStatus(422)
              ->assertJsonValidationErrors(['payment_token']);

});



// create user

//crate products 
//purhcase 

//cerate order
//create order_lines 

// check it about successs and about not success