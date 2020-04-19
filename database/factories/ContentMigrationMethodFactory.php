<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentMigrationMethod;

$factory->define(ContentMigrationMethod::class, static function (Faker $faker) {
    return [
        'display_name' => ucwords($faker->word),
        'name' => $faker->word,
    ];
});
