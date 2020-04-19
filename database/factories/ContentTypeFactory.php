<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Models\ContentType;

$factory->define(ContentType::class, static function (Faker $faker) {
    return [
        'content_migration_method_id' => static function (array $data) {
            return factory(ContentMigrationMethod::class)->create()->id;
        },
        'description' => $faker->sentence,
        'name' => $faker->word,
        'priority' => rand(1, 10),
    ];
});
