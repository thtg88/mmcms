<?php

namespace Thtg88\MmCms\Helpers;

use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Repositories\UserRepository;

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
	 * The user repository implementation.
	 *
	 * @var \Thtg88\MmCms\Repositories\UserRepository
	 */
	protected $users;

	/**
	 * Create a new helper instance.
	 *
	 * @param \Thtg88\MmCms\Repositories\RoleRepository $roles
	 * @param \Thtg88\MmCms\Repositories\UserRepository $users
	 * @return void
	 */
	public function __construct(UserRoleRepository $user_roles, RoleRepository $roles, UserRepository $users)
	{
		$this->roles = $roles;
		$this->users = $users;
	}

	/**
	 * Return whether a user from a given id is authorized
	 * for a certain role from a given id.
	 * This caters for cumulative roles
	 * e.g. if the given role is lower from the one the user owns,
	 * this function will return true.
	 *
	 * @param	int	$user_id	The id of the user.
	 * @param	int	$role_id	The id of the role.
	 * @return	boolean
	 */
	public function authorize($user_id, $role_id)
	{
		// Assume id is numeric and not empty
		if(empty($user_id) || !is_numeric($user_id))
		{
			return false;
		}

		// Assume id is numeric and not empty
		if(empty($role_id) || !is_numeric($role_id))
		{
			return false;
		}

		// Get user
		$user = $this->users->find($user_id);

		if($user === null)
		{
			// If user not found
			return false;
		}

		if($user->role === null)
		{
			// If user not found
			return false;
		}

		// Get role
		$role = $this->roles->find($role_id);

		if($role === null)
		{
			// If role not found
			return false;
		}

		if($user->role !== null && $user->role->priority <= $role->priority)
		{
			// If priority of user's role is lower
			// or equal to the given role's priority,
			// Allow action
			return true;
		}

		return false;
	}

	/**
	 * Return whether a user from a given id is authorized for an administrator role.
	 *
	 * @param	int	$user_id	The id of the user.
	 * @return	boolean
	 */
	public function authorizeAdministrator($user_id)
	{
		return $this->authorize($user_id, config('castle-combe.administrator_role_id'));
	}

	/**
	 * Return whether a user from a given id is authorized for a developer role.
	 *
	 * @param	int	$user_id	The id of the user.
	 * @return	boolean
	 */
	public function authorizeDeveloper($user_id)
	{
		return $this->authorize($user_id, config('castle-combe.developer_role_id'));
	}
}
