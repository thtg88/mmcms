<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Thtg88\MmCms\Events\ContentModelStored;
use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Models\ContentType;

$factory->define(ContentField::class, static function (Faker $faker) {
    return [
        'content_model_id' => static function (array $data) {
            $model = factory(ContentModel::class)->create();

            Container::getInstance()->make('events', [])
                ->dispatch(new ContentModelStored($model));

            return $model->id;
        },
        'content_type_id' => static function (array $data) {
            return factory(ContentType::class)->create()->id;
        },
        'display_name' => static function (array $data) {
            return ucwords($data['name']);
        },
        'helper_text' => $faker->sentence,
        'is_mandatory' => rand(0, 1) === 1,
        'is_resource_name' => rand(0, 1) === 1,
        'name' => $faker->word,
    ];
});
