<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Repositories\RoleRepository;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = Role::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\RoleRepository $repository
     * @return void
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
                Rule::unique($this->repository->getModelTable())
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable())
                    ->where(static function ($query) {
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
