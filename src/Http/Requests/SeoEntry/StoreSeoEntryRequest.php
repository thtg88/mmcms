<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Illuminate\Validation\Rule;
// Helpers
use Thtg88\MmCms\Helpers\DatabaseHelper;
// Requests
use Thtg88\MmCms\Http\Requests\StoreRequest;
// Repositories
use Thtg88\MmCms\Repositories\SeoEntryRepository;

class StoreSeoEntryRequest extends StoreRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\SeoEntryRepository	$repository
	 * @param	\Thtg88\MmCms\Helpers\DatabaseHelper	$database_helper
	 * @return	void
	 */
	public function __construct(SeoEntryRepository $repository, DatabaseHelper $database_helper)
	{
		$this->repository = $repository;
		$this->database_helper = $database_helper;
	}

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
		$table_names = $this->database_helper->getTableNames();

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
			'facebook_image' => 'nullable|string|max:255',
			'facebook_title' => 'nullable|string|max:255',
			'json_schema' => 'nullable|string|json',
			'meta_description' => 'nullable|string|max:255',
			'meta_robots_follow' => 'nullable|string|max:255',
			'meta_robots_index' => 'nullable|string|max:255',
			'meta_title' => 'nullable|string|max:255',
			'page_title' => 'nullable|string|max:255',
			'twitter_description' => 'nullable|string|max:255',
			'twitter_image' => 'nullable|string|max:255',
			'twitter_title' => 'nullable|string|max:255',
        ];

		if(array_key_exists('target_table', $input) && in_array($input['target_table'], $table_names, true))
		{
			$all_rules['target_id'][] = Rule::exists($input['target_table'], 'id')
				->where(function($query) {
					$query->whereNull('deleted_at');
				});
		}

		return $all_rules;
    }
}
