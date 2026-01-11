<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Medicine;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category' => $this->faker->randomElement(['Tablet', 'Sirup', 'Kapsul', 'Salep']),
            'price' => $this->faker->numberBetween(5000, 100000),
            'stock' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->sentence(),
            'full_indication' => $this->faker->paragraph(),
            'usage_detail' => $this->faker->sentence(),
            'side_effects' => $this->faker->sentence(),
            'contraindications' => $this->faker->sentence(),
            'total_sold' => 0,
            // 'image' => null, // Optional
        ];
    }
}
