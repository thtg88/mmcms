<?php

namespace Thtg88\MmCms\Http\Requests\User;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\UserRepository;

class DestroyUserRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\UserRepository	$users
	 * @return	void
	 */
	public function __construct(UserRepository $users)
	{
		$this->repository = $users;
	}
}
