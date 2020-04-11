<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;
use Thtg88\MmCms\Rules\Rule;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\UserRepository $repository
     * @param \Thtg88\MmCms\Repositories\RoleRepository $roles
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
        $all_rules = [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::uniqueCaseInsensitive($this->repository->getModelTable())
                    ->where(function ($query) {
                        $query->whereNull('deleted_at')
                            ->where('id', '<>', $this->route('id'));
                    }),
            ],
            'name' => 'required|string|max:255',
            'role_id' => [
                'required',
                'integer',
                Rule::exists($this->roles->getModelTable(), 'id')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
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
