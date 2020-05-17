<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

$factory->define(ContentType::class, static function (Faker $faker) {
    return [
        'content_migration_method_id' => static function (array $data) {
            return app()->make(ContentMigrationMethodRepository::class)
                ->findRandom()
                ->id;
        },
        'content_validation_rule_id' => static function (array $data) {
            return app()->make(ContentValidationRuleRepository::class)
                ->findRandom()
                ->id;
        },
        'description' => $faker->sentence,
        'name' => $faker->word,
        'priority' => rand(1, 10),
    ];
});
