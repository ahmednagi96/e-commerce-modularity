<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Actions\PurchaseItems;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\PayBuddySdk;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;

// use Modules\Product\Models\Product;

use function Symfony\Component\Clock\now;

class CheckoutController extends Controller

{

    public function __construct(protected PurchaseItems $purchaseItems)
    {
        
    }
    public function __invoke(CheckoutRequest $request)
    {

        $data = $request->validatedData();
        /** @var  CartItemCollection<CartItem> $cartItems */

        $cartItems=CartItemCollection::fromCheckoutData($data['products']);
        $order=$this->purchaseItems->handle(
            items: $cartItems,
            paymentProvider:PayBuddySdk::make(),
            paymentToken:$data['payment_token'],
            userID:$request->user()->id
        );
      
        return response()->json([
            'orderUrl'=>$order->url(),
        ],201);
        

    }
}
