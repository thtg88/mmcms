<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\StoreRequest;
use Thtg88\MmCms\Repositories\UserRepository;

class StoreRequest extends StoreRequest
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
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($this->repository->getName(), 'email')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];
    }
}
