<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Stripe\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\\product>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'desc' => $this->faker->text(),
            'sku' => $this->faker->text(),
            // 'category_id' => function (ProductCategory $product_cat) {
            //     return $product_cat->create()->id;
            // },
            'price' => 499,
            'image' => "products/p1.jpg",
        ];
    }
}
