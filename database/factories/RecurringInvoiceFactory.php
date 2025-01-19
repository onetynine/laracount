<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Company;
use App\Models\Recurring Invoice;

class RecurringInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecurringInvoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => ::factory(),
            'company_id' => Company::factory(),
            'tax_ids' => '{}',
            'product_ids' => '{}',
            'term_id' => $this->faker->randomNumber(),
            'schedule' => '{}',
            'subtotal' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount_type' => $this->faker->randomElement(["flat","percentage"]),
            'total' => $this->faker->randomFloat(2, 0, 999999.99),
            'currency' => $this->faker->word(),
            'note' => $this->faker->word(),
            'status' => $this->faker->randomElement(["active","inactive","cancelled"]),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
