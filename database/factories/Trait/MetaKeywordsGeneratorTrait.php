<?php

namespace Database\Factories\Trait;

use Faker\Generator as FakerGenerator;

trait MetaKeywordsGeneratorTrait
{
    public function generateMetaKeywords(FakerGenerator $faker): string
    {
        $keywords = $this->faker->words($this->faker->numberBetween(3, 5));
        return implode(', ', $keywords);
    }
}
