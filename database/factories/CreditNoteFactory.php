<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use app\models;
use App\Models\Company;
use App\Models\CreditNote;

class CreditNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditNote::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => ::factory(),
            'company_id' => Company::factory(),
            'product_ids' => '{}',
            'invoice_id' => ::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 999999.99),
            'note' => $this->faker->word(),
            'term_id' => $this->faker->randomNumber(),
        ];
    }
}
