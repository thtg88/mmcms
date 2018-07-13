<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\UpdateRequest;
// Repositories
use Thtg88\MmCms\Repositories\UserRepository;

class UpdateUserRequest extends UpdateRequest
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
        $all_rules = [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($this->repository->getName(), 'email')->where(function($query) {
					$query->whereNull('deleted_at')
                        ->where('id', '<>', $this->route('id'));
				}),
            ],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];

        // Get input
        $input = $this->all();

		// Get necessary rules based on input (same keys basically)
		$rules = array_intersect_key($all_rules, $input);

		return $rules;
    }
}
