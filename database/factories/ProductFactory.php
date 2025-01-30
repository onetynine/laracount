<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Product;
use App\Models\Supplier;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'sku' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 0, 999999.99),
            'stock' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(["active","inactive","suspended"]),
            'company_id' => ::factory(),
            'category_id' => ::factory(),
            'tax_id' => ::factory(),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
