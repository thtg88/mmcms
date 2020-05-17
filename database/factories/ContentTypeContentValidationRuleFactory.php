<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\ContentTypeContentValidationRule;
use Thtg88\MmCms\Models\ContentValidationRule;

$factory->define(ContentTypeContentValidationRule::class, static function (Faker $faker) {
    return [
        'content_type_id' => static function (array $data) {
            return factory(ContentType::class)->create()->id;
        },
        'content_validation_rule_id' => static function (array $data) {
            return factory(ContentValidationRule::class)->create()->id;
        },
    ];
});
