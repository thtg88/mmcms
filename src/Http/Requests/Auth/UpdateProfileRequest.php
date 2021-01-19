<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\UserRepository;

class UpdateProfileRequest extends Request
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\UserRepository $users
     *
     * @return void
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
        $all_rules = [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($this->repository->getModelTable())
                    ->where(function ($query) {
                        $query->whereNull('deleted_at')
                            ->where('id', '<>', $this->user()->id);
                    }),
            ],
            'name'     => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];

        // Get input
        $input = $this->all();

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        return $rules;
    }
}
