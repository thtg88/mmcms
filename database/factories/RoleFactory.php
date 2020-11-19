<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Models\Role;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'display_name' => ucwords($this->faker->word),
            'name' => $this->faker->word,
            'priority' => rand(1, 10),
        ];
    }
}
