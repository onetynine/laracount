<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Company;
use App\Models\Debit Note;

class DebitNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DebitNote::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'customer_id' => ::factory(),
            'invoice_id' => ::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 999999.99),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(["pending",""]),
        ];
    }
}
