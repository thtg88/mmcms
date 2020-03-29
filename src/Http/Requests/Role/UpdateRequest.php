<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\RoleRepository;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\RoleRepository	$repository
     * @return	void
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
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
                Rule::unique($this->repository->getModelTable(), 'display_name')->where(function ($query) {
                    $query->whereNull('deleted_at')
                        ->where('id', '<>', $this->route('id'));
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable(), 'name')->where(function ($query) {
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
