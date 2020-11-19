<?php

namespace Thtg88\MmCms\Database\Factories;

use Illuminate\Container\Container;
use Thtg88\MmCms\Events\ContentModelStored;
use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Models\ContentType;

class ContentFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'content_model_id' => static function (array $data) {
                $model = ContentModel::factory()->create();

                Container::getInstance()->make('events', [])
                    ->dispatch(new ContentModelStored($model));

                return $model->id;
            },
            'content_type_id' => static function (array $data) {
                return ContentType::factory()->create()->id;
            },
            'display_name' => static function (array $data) {
                return ucwords($data['name']);
            },
            'helper_text' => $this->faker->sentence,
            'is_mandatory' => rand(0, 1) === 1,
            'is_resource_name' => rand(0, 1) === 1,
            'name' => $this->faker->word,
        ];
    }
}
