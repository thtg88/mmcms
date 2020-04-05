<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Thtg88\MmCms\Models\Role;

$factory->define(Role::class, static function (Faker $faker) {
    return [
        'display_name' => ucwords($faker->word),
        'name' => $faker->word,
        'priority' => rand(1, 10),
    ];
});
