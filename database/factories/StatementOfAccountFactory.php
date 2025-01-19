<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Company;
use App\Models\Statement of Account;

class StatementOfAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StatementOfAccount::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'customer_id' => ::factory(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'total_due' => $this->faker->randomFloat(2, 0, 999999.99),
            'currency' => $this->faker->word(),
        ];
    }
}
