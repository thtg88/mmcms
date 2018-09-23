<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\UpdateRequest;
// Repositories
use Thtg88\MmCms\Repositories\RoleRepository;

class UpdateRoleRequest extends UpdateRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all_rules = [
            'display_name' => [
				'required',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'display_name')->where(function($query) {
					$query->whereNull('deleted_at')
						->where('id', '<>', $this->route('id'));
				}),
			],
            'name' => [
				'required',
				'string',
				'max:255',
				Rule::unique($this->repository->getName(), 'name')->where(function($query) {
					$query->whereNull('deleted_at')
						->where('id', '<>', $this->route('id'));
				}),
			],
			'priority' => [
				'required',
				'integer',
				'min:1',
			],
        ];

        // Get input
        $input = $this->all();

		// Get necessary rules based on input (same keys basically)
		$rules = array_intersect_key($all_rules, $input);

		return $rules;
    }
}
