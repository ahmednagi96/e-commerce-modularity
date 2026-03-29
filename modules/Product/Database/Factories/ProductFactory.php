<?php

namespace Modules\Product\Database\Factories;
use Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
   protected $model = Product::class;
    public function definition(): array
    {
        return [
            // استخدام الهيلبر المباشر أضمن في لارفيل
            'name'           => fake()->sentence(), 
            'price_in_cents' => fake()->numberBetween(1, 5000),
            'stock'          => fake()->numberBetween(1, 50),
        ];
    }
}
