<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Tax;

class TaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'type' => $this->faker->word(),
            'rate' => $this->faker->randomFloat(0, 0, 9999999999.),
            'description' => $this->faker->text(),
            'country' => $this->faker->country(),
        ];
    }
}
