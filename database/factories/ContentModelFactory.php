<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Thtg88\MmCms\Models\ContentModel;

$factory->define(ContentModel::class, static function (Faker $faker) {
    return [
        'base_route_name' => static function (array $data) {
            return Str::slug($data['name']);
        },
        'description' => $faker->sentence,
        'model_name' => static function (array $data) {
            return Str::studly($data['name']);
        },
        'name' => $faker->words(3, true),
        'table_name' => static function (array $data) {
            return Str::snake($data['name']);
        },
    ];
});
