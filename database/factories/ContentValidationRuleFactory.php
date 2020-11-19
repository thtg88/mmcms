<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Models\ContentValidationRule;

class ContentValidationRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentValidationRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
