<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\UpdateRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentModelRepository;

class UpdateContentModelRequest extends UpdateRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\ContentModelRepository	$repository
	 * @return	void
	 */
	public function __construct(ContentModelRepository $repository)
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
        $all_rules = [
			'description' => [
				'nullable',
				'string',
			],
            'display_name' => [
				'required',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'display_name')->where(function($query) {
					$query->whereNull('deleted_at')
						->where('id', '<>', $this->route('id'));
				}),
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
        ];

        // Get input
        $input = $this->all();

		// Get necessary rules based on input (same keys basically)
		$rules = array_intersect_key($all_rules, $input);

		return $rules;
    }
}