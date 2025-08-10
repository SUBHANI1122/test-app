<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TranslationFactory extends Factory
{
    protected $model = \App\Models\Transalation::class;

    public function definition(): array
    {
        $locales = ['en', 'fr', 'es', 'de', 'pt'];

        return [
            'key' => 'key_' . Str::random(12),
            'locale' => $this->faker->randomElement($locales),
            'content' => $this->faker->sentence(6),
            'context' => $this->faker->randomElement(['web', 'mobile', 'desktop']),
        ];
    }
}