<?php

namespace Thtg88\MmCms\Database\Factories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Models\SeoEntry;

class SeoEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeoEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $table_names = config('mmcms.modules.seo.allowed_target_tables');

        $table_names_count = count($table_names);

        $table_names_idx = rand(0, $table_names_count - 1);

        return [
            'facebook_description' => $this->faker->sentence,
            'facebook_image' => $this->faker->url,
            'facebook_title' => $this->faker->word,
            'json_schema' => null,
            'meta_description' => $this->faker->sentence,
            'meta_robots_follow' => rand(0, 1) === 0 ? 'follow' : 'nofollow',
            'meta_robots_index' => rand(0, 1) === 0 ? 'index' : 'noindex',
            'meta_title' => $this->faker->word,
            'page_title' => $this->faker->word,
            'target_id' => static function (array $data) {
                $model_classname = config('mmcms.models.namespace').
                    Str::title(Str::singular($data['target_table'])).'';

                if (class_exists($model_classname)) {
                    return call_user_func($model_classname.'::factory')
                        ->create()
                        ->id;
                }

                return null;
            },
            'target_table' => $table_names[$table_names_idx],
            'twitter_description' => $this->faker->sentence,
            'twitter_image' => $this->faker->url,
            'twitter_title' => $this->faker->word,
        ];
    }
}
