<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $index = fake()->unique()->numberBetween(1, 10); // Ajuste o intervalo conforme necessário
        return [
            'name' => "Celular {$index}",
            'price' => fake()->randomFloat(2, 100, 1000),
            'description' => fake()->sentence,
        ];
    }
}
