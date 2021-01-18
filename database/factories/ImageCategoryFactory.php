<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Models\ImageCategory;

class ImageCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ImageCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name'         => $this->faker->word,
            'sequence'     => rand(1, 10),
            'target_table' => static function (array $data) {
                $table_names = app()->make(DatabaseHelper::class)->getTableNames();

                $table_idx = rand(0, count($table_names) - 1);

                $target_table = $table_names[$table_idx];

                return $target_table;
            },
        ];
    }
}
