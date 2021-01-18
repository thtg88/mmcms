<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Models\ContentMigrationMethod;

class ContentMigrationMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentMigrationMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'display_name' => ucwords($this->faker->word),
            'name'         => $this->faker->word,
        ];
    }
}
