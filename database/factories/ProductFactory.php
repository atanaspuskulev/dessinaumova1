<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 2), // Random between 1 and 2
            'title' => $this->faker->unique()->sentence,
            'short_description' => $this->faker->text(100), // Adjust the length as needed
            'description' => $this->faker->text,
            'material' => $this->faker->word,
            'dimentions1' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'sold' => $this->faker->boolean,
            'delivery' => $this->faker->sentence,
            'meta_title' => $this->faker->sentence,
            'meta_keywords' => $this->generateMetaKeywords(),
            'meta_description' => $this->faker->text(50)
        ];
    }

    public function softDeleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => now(),
            ];
        });
    }

    private function generateMetaKeywords(): string
    {
        $keywords = $this->faker->words($this->faker->numberBetween(3, 5));
        return implode(', ', $keywords);
    }
}
