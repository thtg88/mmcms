<?php

namespace Thtg88\MmCms\Helpers;

use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\RoleRepository;

/**
 * Helper methods for user role.
 */
class UserRoleHelper
{
    /**
     * The user repository implementation.
     *
     * @var \Thtg88\MmCms\Repositories\RoleRepository
     */
    protected $roles;

    /**
     * Create a new helper instance.
     *
     * @param \Thtg88\MmCms\Repositories\RoleRepository $roles
     *
     * @return void
     */
    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Return whether a user from a given id is authorized
     * for a certain role from a given id.
     * This caters for cumulative roles
     * e.g. if the given role is lower from the one the user owns,
     * this function will return true.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @param string                    $role_name The name of the role.
     *
     * @return bool
     */
    public function authorize(User $user, $role_name): bool
    {
        // Assume name is string and not empty
        if (empty($role_name) || !is_string($role_name)) {
            return false;
        }

        // If user role not found
        if ($user->role === null) {
            return false;
        }

        // Get role
        $role = $this->roles->findByModelName($role_name);

        // If role not found
        if ($role === null) {
            return false;
        }

        // If priority of user's role is greater
        // than the given role's priority, disallow action
        if ($user->role->priority > $role->priority) {
            return false;
        }

        return true;
    }

    /**
     * Return whether a given user is authorized for an administrator role.
     *
     * @param \Thtg88\MmCms\Models\User $user
     *
     * @return bool
     */
    public function authorizeAdministrator(User $user)
    {
        return $this->authorize(
            $user,
            Config::get('mmcms.roles.names.administrator')
        );
    }

    /**
     * Return whether a user from a given id is authorized for a developer role.
     *
     * @param \Thtg88\MmCms\Models\User $user
     *
     * @return bool
     */
    public function authorizeDeveloper(User $user)
    {
        return $this->authorize(
            $user,
            Config::get('mmcms.roles.names.developer')
        );
    }
}
