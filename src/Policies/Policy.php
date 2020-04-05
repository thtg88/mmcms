<?php

namespace Thtg88\MmCms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Thtg88\MmCms\Helpers\UserRoleHelper;
use Thtg88\MmCms\Models\User;

abstract class Policy
{
    use HandlesAuthorization;

    /**
     * The user role helper implementation.
     *
     * @var \Thtg88\MmCms\Helpers\UserRoleHelper
     */
    protected $user_role_helper;

    /**
     * Create a new helper instance.
     *
     * @param \Thtg88\MmCms\Helpers\UserRoleHelper $user_role_helper
     * @return void
     */
    public function __construct(UserRoleHelper $user_role_helper)
    {
        $this->user_role_helper = $user_role_helper;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $this->user_role_helper->authorizeDeveloper($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @param \Illuminate\Eloquent\Database\Model $model
     * @return mixed
     */
    public function view(User $user, Model $model)
    {
        return $this->user_role_helper->authorizeDeveloper($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->user_role_helper->authorizeDeveloper($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @param \Illuminate\Eloquent\Database\Model $model
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        if ($this->user_role_helper->authorizeDeveloper($user) === false) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @param \Illuminate\Eloquent\Database\Model $model
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        if ($this->user_role_helper->authorizeDeveloper($user) === false) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @param \Illuminate\Eloquent\Database\Model $model
     * @return mixed
     */
    public function restore(User $user, Model $model)
    {
        if ($this->user_role_helper->authorizeDeveloper($user) === false) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \Thtg88\MmCms\Models\User $user
     * @param \Illuminate\Eloquent\Database\Model $model
     * @return mixed
     */
    public function forceDelete(User $user, Model $model)
    {
        if ($this->user_role_helper->authorizeDeveloper($user) === false) {
            return false;
        }

        return true;
    }
}
