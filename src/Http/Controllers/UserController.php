<?php

namespace Thtg88\MmCms\Http\Controllers;

// Repositories
use Illuminate\Config\Repository as Config;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;
// Requests
use Thtg88\MmCms\Http\Requests\User\DestroyUserRequest;
use Thtg88\MmCms\Http\Requests\User\StoreUserRequest;
use Thtg88\MmCms\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Thtg88\MmCms\Repositories\UserRepository $repository
     * @param \Thtg88\MmCms\Repositories\RoleRepository $roles
     * @return void
     */
    public function __construct(UserRepository $repository, RoleRepository $roles)
    {
        $this->repository = $repository;
        $this->roles = $roles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\User\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // Get input
        $input = $request->except(['created_at']);

        if (array_key_exists('password', $input) && !empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        if (!array_key_exists('role_id', $input)) {
            // Get user role
            $user_role = $this->roles->findByModelName(
                Config::get('mmcms.roles.user_role_name')
            );

            if ($user_role !== null) {
                // If found - assign it to the user registering
                $input['role_id'] = $user_role->id;
            }
        }

        // Create
        $resource = $this->repository->create($input);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\User\UpdateUserRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // Get input
        $input = $request->except(['created_at']);

        if (array_key_exists('password', $input) && !empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        // Update
        $resource = $this->repository->update($id, $input);

        // No need to check if found as done by authorization method

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Thtg88\MmCms\Http\Requests\User\DestroyUserRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyUserRequest $request, $id)
    {
        // Delete resource
        $resource = $this->repository->destroy($id);

        return response()->json([
            'success' => true,
            'resource' => $resource,
        ]);
    }
}
