<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Relations\Relation;
use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Models\SeoEntry;

$factory->define(SeoEntry::class, static function (Faker $faker) {
    $table_names = $this->database_helper->getTableNames();

    $table_names_count = count($table_names);

    $table_names_idx = rand(0, $table_names_count - 1);

    return [
        'facebook_description' => $faker->sentence,
        'facebook_image' => $faker->url,
        'facebook_title' => $faker->word,
        'json_schema' => null,
        'meta_description' => $faker->sentence,
        'meta_robots_follow' => rand(0, 1) === 0 ? 'follow' : 'nofollow',
        'meta_robots_index' => rand(0, 1) === 0 ? 'index' : 'noindex',
        'meta_title' => $faker->word,
        'page_title' => $faker->word,
        'target_id' => static function (array $data) {
            $model_classname = config('mmcms.models.namespace').
                Str::title(Str::singular($data['target_table'])).'';

            if (class_exists($model_classname)) {
                return factory($model_classname)->create()->id;
            }

            return null;
        },
        'target_table' => $table_names[$table_names_idx],
        'twitter_description' => $faker->sentence,
        'twitter_image' => $faker->url,
        'twitter_title' => $faker->word,
    ];
});
