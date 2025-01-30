<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Company;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'industry' => $this->faker->word(),
            'code' => $this->faker->word(),
            'business_address' => '{}',
            'registration_address' => '{}',
            'country_of_registration' => $this->faker->word(),
            'registration_number' => $this->faker->word(),
            'contact_number' => $this->faker->word(),
            'status' => $this->faker->randomElement(["inactive","active","suspended"]),
        ];
    }
}
