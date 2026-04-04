<?php 

namespace Modules\Product\DTOs;

readonly class CartItemDto{
    public function __construct(

        public ProductDto $productDto,
        public int $quantity
    )
    {
      
    }
}