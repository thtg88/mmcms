<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\StoreRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentModelRepository;

class StoreContentModelRequest extends StoreRequest
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
        return [
			'base_route_name' => [
				'nullable',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'base_route_name')->where(function($query) {
					$query->whereNull('deleted_at');
				}),
			],
			'description' => [
				'nullable',
				'string',
			],
            'model_name' => [
				'nullable',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'model_name')->where(function($query) {
					$query->whereNull('deleted_at');
				}),
			],
            'name' => [
				'required',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'name')->where(function($query) {
					$query->whereNull('deleted_at');
				}),
			],
			'table_name' => [
				'nullable',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'table_name')->where(function($query) {
					$query->whereNull('deleted_at');
				}),
			],
        ];
    }
}
