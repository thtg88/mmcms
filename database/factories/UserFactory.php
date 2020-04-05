<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;

$factory->define(User::class, static function (Faker $faker) {
    return [
        'email' => $faker->safeEmail(),
        'name' => $faker->name(),
        'password' => Str::random(8),
        'role_id' => config('app.roles.default_role_id'),
    ];
});

$factory->state(User::class, 'email_verified', [
    'email_verified_at' => now(),
]);

$factory->state(User::class, 'admin', [
    'role_id' => config('app.roles.ids.administrator'),
]);

$factory->state(User::class, 'dev', [
    'role_id' => config('app.roles.ids.developer'),
]);

$factory->state(User::class, 'user', [
    'role_id' => config('app.roles.ids.user'),
]);
