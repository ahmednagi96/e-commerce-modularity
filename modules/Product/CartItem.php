<?php 

namespace Modules\Product;
use Modules\Product\Models\Product;
use Modules\Product\ProductDto;

readonly class CartItem{
    public function __construct(

        public ProductDto $productDto,
        public int $quantity
    )
    {
      
    }
}