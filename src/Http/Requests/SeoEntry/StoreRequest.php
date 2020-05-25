<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\SeoEntry;
use Thtg88\MmCms\Repositories\SeoEntryRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = SeoEntry::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\SeoEntryRepository $repository
     * @return void
     */
    public function __construct(SeoEntryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get input
        $input = $this->all();

        // Get all tables
        $table_names = config('mmcms.modules.seo.allowed_target_tables');

        $all_rules = [
            'target_id' => [
                'required',
                'integer',
            ],
            'target_table' => [
                'required',
                'string',
                'in:'.implode(',', $table_names),
            ],
            'facebook_description' => 'nullable|string|max:255',
            'facebook_image' => 'nullable|string|max:2000',
            'facebook_title' => 'nullable|string|max:255',
            'json_schema' => 'nullable|string|json',
            'meta_description' => 'nullable|string|max:255',
            'meta_robots_follow' => 'nullable|string|max:255',
            'meta_robots_index' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'page_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'twitter_image' => 'nullable|string|max:2000',
            'twitter_title' => 'nullable|string|max:255',
        ];

        if (
            array_key_exists('target_table', $input) &&
            in_array($input['target_table'], $table_names, true)
        ) {
            $all_rules['target_id'][] = Rule::existsWithoutSoftDeleted(
                $input['target_table'],
                'id'
            );
        }

        return $all_rules;
    }
}
