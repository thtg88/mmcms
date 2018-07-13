<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\Request;
// Repositories
use Thtg88\MmCms\Repositories\UserRepository;

class LoginRequest extends Request
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
                Rule::exists($this->repository->getName(), 'email')->where(function($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'password' => 'required|min:6',
        ];
    }
}
