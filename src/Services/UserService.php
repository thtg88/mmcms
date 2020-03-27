<?php

namespace Thtg88\MmCms\Services;

use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;

class UserService extends ResourceService
{
    /**
     * The role repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\RoleRepository
     */
    protected $roles;

    /**
     * Create a new service instance.
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
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\Contracts\StoreRequestInterface $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreRequestInterface $request)
    {
        $data = $request->validated();

        if (! array_key_exists('role_id', $data) || empty($data['role_id'])) {
            // Get user role
            $user_role = $this->roles->findByModelName(
                Config::get('mmcms.roles.user_role_name')
            );

            if ($user_role !== null) {
                // If found - assign it to the user registering
                $data['role_id'] = $user_role->id;
            }
        }

        return $this->repository->create($data);
    }
}
