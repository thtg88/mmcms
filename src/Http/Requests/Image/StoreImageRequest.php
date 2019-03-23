<?php

namespace App\Http\Requests\Image;

use Illuminate\Validation\Rule;
// Helpers
use SdSomersetDesign\CastleCombe\Helpers\DatabaseHelper;
// Requests
use SdSomersetDesign\CastleCombe\Http\Requests\StoreRequest;
// Repositories
use SdSomersetDesign\CastleCombe\Repositories\ImageRepository;

class StoreImageRequest extends StoreRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\SdSomersetDesign\CastleCombe\Repositories\ImageRepository	$repository
	 * @param	\SdSomersetDesign\CastleCombe\Helpers\DatabaseHelper	$database_helper
	 * @return	void
	 */
	public function __construct(ImageRepository $repository, DatabaseHelper $database_helper)
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
			'caption' => 'nullable|string',
			'data' => 'required_without:url|file|mimes:jpg,jpeg,png,gif',
			'name' => 'nullable|string|max:255',
			'target_id' => [
				'required',
				'integer',
			],
			'target_table' => [
				'nullable',
				'string',
				'in:'.implode(',', $table_names),
			],
			'title' => 'nullable|string|max:255',
			'url' => 'required_without:data|string|max:2000',
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
