<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Models\ContentFieldContentValidationRule;
use Thtg88\MmCms\Models\ContentValidationRule;

class ContentFieldContentValidationRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentFieldContentValidationRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'content_field_id' => static function (array $data) {
                return ContentField::factory()->create()->id;
            },
            'content_validation_rule_id' => static function (array $data) {
                return ContentValidationRule::factory()->create()->id;
            },
        ];
    }
}
