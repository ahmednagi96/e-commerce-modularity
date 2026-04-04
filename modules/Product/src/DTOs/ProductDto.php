<?php 

namespace Modules\Product\DTOs;

use Modules\Product\Models\Product;

readonly class ProductDto
{
    public function __construct(
        public int $id,
        public string $name,
        public float $priceInCents,
        public int $stock
    )
    {
        
    }


    public static function fromEloquentMOdel(Product $product): ProductDto
    {
        return new self(
            id: $product->id,
            name: $product->name,
            priceInCents: $product->price_in_cents,
            stock: $product->stock
        );
    }
}