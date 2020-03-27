<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\UpdateRequest;
use Thtg88\MmCms\Repositories\UserRepository;

class UpdateRequest extends UpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\UserRepository	$repository
     * @return	void
     */
    public function __construct(UserRepository $repository)
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
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($this->repository->getName(), 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')
                        ->where('id', '<>', $this->route('id'));
                }),
            ],
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];

        // Get input
        $input = $this->all();

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        return $rules;
    }
}
