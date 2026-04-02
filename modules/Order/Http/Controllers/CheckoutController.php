<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Actions\PurchaseItems;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\DTOs\PendingPayment;
use Modules\Payment\Interfaces\PaymentGateway;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\User\DTOs\UserDto;

// use Modules\Product\Models\Product;

use function Symfony\Component\Clock\now;

class CheckoutController extends Controller

{

    public function __construct(
        protected PurchaseItems $purchaseItems,
        protected PaymentGateway $paymentGateway
        )
    {
        
    }
    public function __invoke(CheckoutRequest $request)
    {

        $data = $request->validatedData();

        /** @var  CartItemCollection<CartItem> $cartItems */
        $cartItems=CartItemCollection::fromCheckoutData($data['products']);

        /** @var  PendingPayment $payment */
        $pendingPayment=new PendingPayment($this->paymentGateway,$data['payment_token']);

        /** @var UserDto $userDto */
        $userDto=UserDto::fromEloguentModel($request->user());


        $orderDto=$this->purchaseItems->handle(
            items: $cartItems,
            pendingPayment: $pendingPayment,
            userDTO: $userDto
        );
      
        return response()->json([
            'orderUrl'=>$orderDto->url,
        ],201);
        

    }
}
