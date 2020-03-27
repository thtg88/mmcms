<?php

namespace Thtg88\MmCms\Http\Requests\ContentMigrationMethod;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\StoreRequest;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

class StoreRequest extends StoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\ContentMigrationMethodRepository	$repository
     * @return	void
     */
    public function __construct(ContentMigrationMethodRepository $repository)
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
            'display_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique($this->repository->getName(), 'display_name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getName(), 'name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
        ];
    }
}
