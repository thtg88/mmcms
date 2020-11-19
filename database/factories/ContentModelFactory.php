<?php

namespace Thtg88\MmCms\Database\Factories;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\ContentModel;

class ContentModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'base_route_name' => static function (array $data) {
                return Str::slug($data['name']);
            },
            'description' => $this->faker->sentence,
            'model_name' => static function (array $data) {
                return Str::studly($data['name']);
            },
            'name' => $this->faker->words(3, true),
            'table_name' => static function (array $data) {
                return Str::snake($data['name']);
            },
        ];
    }
}
