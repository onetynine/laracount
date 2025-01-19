<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Company;
use App\Models\Sales Order;

class SalesOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrder::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => ::factory(),
            'company_id' => Company::factory(),
            'invoice_id' => $this->faker->randomNumber(),
            'term_id' => $this->faker->randomNumber(),
            'product_ids' => '{}',
            'subtotal' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount_type' => $this->faker->randomElement(["flat","percentage"]),
            'total' => $this->faker->randomFloat(2, 0, 999999.99),
            'currency' => $this->faker->word(),
            'note' => $this->faker->word(),
            'status' => $this->faker->randomElement(["pending","approved","rejected","paid","cancelled"]),
        ];
    }
}
