<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

class ContentTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'content_migration_method_id' => static function (array $data) {
                return app()->make(ContentMigrationMethodRepository::class)
                    ->findRandom()
                    ->id;
            },
            'description' => $this->faker->sentence,
            'name' => $this->faker->word,
            'priority' => rand(1, 10),
        ];
    }
}
