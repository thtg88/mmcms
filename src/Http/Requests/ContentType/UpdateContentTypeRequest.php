<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\UpdateRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class UpdateContentTypeRequest extends UpdateRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\ContentTypeRepository	$repository
	 * @return	void
	 */
	public function __construct(ContentTypeRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorizeDeveloper();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all_rules = [
			'description' => [
				'nullable',
				'string',
			],
			'migration_method_name' => [
				'nullable',
				'string',
			],
            'name' => [
				'required',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'name')->where(function($query) {
					$query->whereNull('deleted_at')
						->where('id', '<>', $this->route('id'));
				}),
			],
			'priority' => [
				'required',
				'integer',
				'min:1',
			],
        ];

        // Get input
        $input = $this->all();

		// Get necessary rules based on input (same keys basically)
		$rules = array_intersect_key($all_rules, $input);

		return $rules;
    }
}