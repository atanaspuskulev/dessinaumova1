<?php

namespace Database\Factories;

use Database\Factories\Trait\MetaKeywordsGeneratorTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    use MetaKeywordsGeneratorTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->randomElement(['Paintings', 'Prints']),
            'description' => $this->faker->text,
            'is_active' => true,
            'meta_title' => $this->faker->sentence,
            'meta_keywords' => $this->generateMetaKeywords($this->faker),
            'meta_description' => $this->faker->text(50)
        ];
    }
}
