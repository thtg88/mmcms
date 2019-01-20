<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\StoreRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class StoreContentTypeRequest extends StoreRequest
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
        return [
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
					$query->whereNull('deleted_at');
				}),
			],
			'priority' => [
				'required',
				'integer',
				'min:1',
			],
        ];
    }
}
