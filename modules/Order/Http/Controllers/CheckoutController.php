<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderLine;
use Modules\Payment\PayBuddySdk;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

// use Modules\Product\Models\Product;

use function Symfony\Component\Clock\now;

class CheckoutController extends Controller

{

    public function __construct(public ProductStockManager $productStockManager)
    {
        
    }
    public function __invoke(CheckoutRequest $request)
    {

        $data = $request->validatedData();
        /** @var  CartItemCollection<CartItem> $cartItems */
        $cartItems=CartItemCollection::formCheckoutData($data['products']);
        $orderTotal=$cartItems->totalInCents();

        
        /** payment module */
        $payBuddy=PayBuddySdk::make();
        
        $charge=$payBuddy->charge($data["payment_token"],$orderTotal,"charge for order"); 
        
        
        // create order

        /** order module */
        $order=Order::query()->create([
            "payment_id"=>$charge["id"],
            "payment_method"=>"payBubble",
            "status"=>"paid",
            "total_in_cents"=>$orderTotal,
            "user_id"=>$request->user()->id,
        ]);

        // drecease stock after create order
        $cartItems->items()->each(function (CartItem $cartItem){
            $this->productStockManager->decrement($cartItem->productDto->id,$cartItem->quantity);
        });
       //create order_lines
     $orderLinesData=$cartItems->items()->map(function (CartItem $cartItem)use ($order){
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
        return response()->json([],201);
        

    }
}
