<?php 

namespace Modules\Order\Actions;

use Modules\Order\Models\Order;
use Modules\Order\Models\OrderLine;
use Modules\Payment\PayBuddySdk;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems{

    public function __construct(public ProductStockManager $productStockManager)
    {   
    
    }
    
    public function handle(CartItemCollection $items,PayBuddySdk $paymentProvider,string $paymentToken,int $userID){
      
        $orderTotal=$items->totalInCents();
        $charge=$paymentProvider->charge($paymentToken,$orderTotal,"charge for order"); 
        // create order
        /** order module */
        $order=Order::query()->create([
            "payment_id"=>$charge["id"],
            "payment_method"=>"payBubble",
            "status"=>"paid",
            "total_in_cents"=>$orderTotal,
            "user_id"=>$userID,
        ]);

        // drecease stock after create order
        $items->items()->each(function (CartItem $cartItem){
            $this->productStockManager->decrement($cartItem->productDto->id,$cartItem->quantity);
        });


        /** create payment data */
        $order->payments()->create([
            "payment_id"=>$charge["id"],
            "payment_gateway"=>"payBubble",
            "status"=>"paid",
            "total_in_cents"=>$orderTotal,
            "user_id"=>$userID,
        ]);
       //create order_lines
     $orderLinesData=$items->items()->map(function (CartItem $cartItem)use ($order){
        return [
            "product_id"=>$cartItem->productDto->id,
            "order_id"=>$order->id,
            "product_price_in_cents"=>$cartItem->productDto->priceInCents,
            "quantity"=> $cartItem->quantity,
            "created_at"=>now(),
            "updated_at"=>now(),
        ];
    })->toArray();
        OrderLine::insert($orderLinesData);
    }
}
