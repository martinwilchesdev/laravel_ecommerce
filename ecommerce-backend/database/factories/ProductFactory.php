<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        return [
            'nombre' => fake()->sentence(3),
            'descripcion' => fake()->sentence(),
            'precio' => fake()->randomFloat(2, 100, 1000),
            'imagen' => fake()->imageUrl()
        ];
    }
}
