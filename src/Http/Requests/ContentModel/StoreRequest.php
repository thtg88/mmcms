<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Repositories\ContentModelRepository;

class StoreRequest extends BaseStoreRequest
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
                Rule::unique($this->repository->getModelTable(), 'base_route_name')->where(function ($query) {
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
                Rule::unique($this->repository->getModelTable(), 'model_name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable(), 'name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'table_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable(), 'table_name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
        ];
    }
}
