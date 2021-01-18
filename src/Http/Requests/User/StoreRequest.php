<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = User::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\UserRepository $repository
     * @param \Thtg88\MmCms\Repositories\RoleRepository $roles
     *
     * @return void
     */
    public function __construct(
        UserRepository $repository,
        RoleRepository $roles
    ) {
        $this->repository = $repository;

        $this->roles = $roles;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::uniqueCaseInsensitive($this->repository->getModelTable())
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'name'     => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
            'role_id'  => [
                'required',
                'integer',
                Rule::existsWithoutSoftDeleted(
                    $this->roles->getModelTable(),
                    'id'
                ),
            ],
        ];
    }
}
