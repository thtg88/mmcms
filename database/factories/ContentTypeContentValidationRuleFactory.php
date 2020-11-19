<?php

namespace Thtg88\MmCms\Database\Factories;

use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\ContentTypeContentValidationRule;
use Thtg88\MmCms\Models\ContentValidationRule;

class ContentTypeContentValidationRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContentTypeContentValidationRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'content_type_id' => static function (array $data) {
                return ContentType::factory()->create()->id;
            },
            'content_validation_rule_id' => static function (array $data) {
                return ContentValidationRule::factory()->create()->id;
            },
        ];
    }
}
