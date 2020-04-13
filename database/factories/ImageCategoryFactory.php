<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Models\ImageCategory;

$factory->define(ImageCategory::class, static function (Faker $faker) {
    return [
        'name' => $faker->word,
        'sequence' => rand(1, 10),
        'target_table' => static function (array $data) {
            $table_names = app()->make(DatabaseHelper::class)->getTableNames();

            $table_idx = rand(0, count($table_names) - 1);

            $target_table = $table_names[$table_idx];

            return $target_table;
        },
    ];
});
