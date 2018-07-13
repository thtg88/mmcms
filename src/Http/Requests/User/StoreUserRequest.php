<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\StoreRequest;
// Repositories
use Thtg88\MmCms\Repositories\UserRepository;

class StoreUserRequest extends StoreRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
				'required',
				'email',
				'max:255',
				Rule::unique($this->repository->getName(), 'email')->where(function($query) {
					$query->whereNull('deleted_at');
				}),
			],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];
    }
}
