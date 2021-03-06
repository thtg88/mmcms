<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\SeoEntryRepository;
use Thtg88\MmCms\Rules\Rule;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\SeoEntryRepository $repository
     *
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

        $table_names = config('mmcms.modules.seo.allowed_target_tables');

        // We define the real table name in order to check if the target exists
        // First we check if the provided input contains a table name
        if (
            array_key_exists('target_table', $input) &&
            in_array($input['target_table'], $table_names, true)
        ) {
            // If so, this is the table name we are going to use for our validation
            $real_table_name = $input['target_table'];
        } else {
            // Otherwise use the existing table name
            $real_table_name = $this->resource->target_table;
        }

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
            'facebook_image'       => 'nullable|string|max:2000',
            'facebook_title'       => 'nullable|string|max:255',
            'json_schema'          => 'nullable|string|json',
            'meta_description'     => 'nullable|string|max:255',
            'meta_robots_follow'   => 'nullable|string|max:255',
            'meta_robots_index'    => 'nullable|string|max:255',
            'meta_title'           => 'nullable|string|max:255',
            'page_title'           => 'nullable|string|max:255',
            'twitter_description'  => 'nullable|string|max:255',
            'twitter_image'        => 'nullable|string|max:2000',
            'twitter_title'        => 'nullable|string|max:255',
        ];

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        if (
            in_array($real_table_name, $table_names, true)
            && (
                array_key_exists('target_id', $input)
                || array_key_exists('target_table', $input)
            )
        ) {
            // If it's in the list of tables, we want to check it's a valid id in that table
            $rules['target_id'][] = Rule::existsWithoutSoftDeleted(
                $real_table_name,
                'id'
            );
        }

        return $rules;
    }
}
