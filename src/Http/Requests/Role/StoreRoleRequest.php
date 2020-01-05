<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\StoreRequest;
// Repositories
use Thtg88\MmCms\Repositories\RoleRepository;

class StoreRoleRequest extends StoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\RoleRepository	$repository
     * @return	void
     */
    public function __construct(RoleRepository $repository)
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
                'required',
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
            'priority' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}
