<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Company;
use App\Models\Payment;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'customer_id' => ::factory(),
            'invoice_id' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomFloat(2, 0, 999999.99),
            'payment_method' => $this->faker->randomElement(["bank_transfer",""]),
            'transaction_reference' => $this->faker->word(),
            'payment_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["completed",""]),
        ];
    }
}
