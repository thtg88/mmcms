<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

$factory->define(ContentType::class, static function (Faker $faker) {
    return [
        'content_migration_method_id' => static function (array $data) {
            return app()->make(ContentMigrationMethodRepository::class)
                ->findRandom()
                ->id;
        },
        'description' => $faker->sentence,
        'name' => $faker->word,
        'priority' => rand(1, 10),
    ];
});
