<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Models\ContentFieldContentValidationRule;
use Thtg88\MmCms\Models\ContentValidationRule;

$factory->define(ContentFieldContentValidationRule::class, static function (Faker $faker) {
    return [
        'content_field_id' => static function (array $data) {
            return factory(ContentField::class)->create()->id;
        },
        'content_validation_rule_id' => static function (array $data) {
            return factory(ContentValidationRule::class)->create()->id;
        },
    ];
});
