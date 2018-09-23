<?php

namespace Thtg88\MmCms\Http\Requests\Role;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\RoleRepository;

class DestroyRoleRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\RoleRepository	$roles
	 * @return	void
	 */
	public function __construct(RoleRepository $roles)
	{
		$this->repository = $roles;
	}
}