<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\UserRepository;
use Illuminate\Validation\Rule;

class RegisterRequest extends Request
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
				'max:255',
				Rule::unique($this->repository->getName(), 'email')->where(function($query) {
					$query->whereNull('deleted_at');
				}),
			],
			'g_recaptcha_response' => 'bail|required|captcha',
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];
    }
}
