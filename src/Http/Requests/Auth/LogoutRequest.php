<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\UserRepository;

class LogoutRequest extends Request
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

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
