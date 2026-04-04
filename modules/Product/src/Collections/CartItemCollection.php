<?php

namespace  Modules\Product\Collections;

use Illuminate\Support\Collection;
use Modules\Product\DTOs\CartItemDto;
use Modules\Product\DTOs\ProductDto;
use Modules\Product\Models\Product;

class CartItemCollection
{
    /**
     *  @param Collection<CartItemDto> $items 
     * */
    public function __construct(
        private Collection $items
    ) {}

    public static function fromCheckoutData(array $data): CartItemCollection
    {
        /**  @var Collection<CartItemDto> $cartItems */
        $cartItems = collect($data)->map(function (array $product) {
            return new CartItemDto(ProductDto::fromEloquentMOdel(Product::find($product['id'])), $product['quantity']);
        });
        return new self($cartItems);
    }

    /** 
     * @return Collection<CartItemDto> 
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
