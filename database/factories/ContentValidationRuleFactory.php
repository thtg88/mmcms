<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentValidationRule;

$factory->define(ContentValidationRule::class, static function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
