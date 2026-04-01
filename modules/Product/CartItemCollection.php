<?php 

namespace  Modules\Product;

use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

class CartItemCollection
{
        /**
         *  @param Collection<CartItem> $items 
         * */
        public function __construct(
            private Collection $items
        )
        {            
        }

        public static function fromCheckoutData(array $data): CartItemCollection
        {
             /**  @var Collection<CartItem> $cartItems */
            $cartItems=collect($data)->map(function (array $product) {
            return new CartItem(ProductDto::fromEloquentMOdel(Product::find($product['id'])),$product['quantity']) ;
                });
                return new self($cartItems);
        }

        /** 
         * @return Collection<CartItem> 
         */
        public function items(): Collection
        {
            return $this->items;
        }

       
}