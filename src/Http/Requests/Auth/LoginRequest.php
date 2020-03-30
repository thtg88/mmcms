<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\UserRepository;

class LoginRequest extends Request
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\UserRepository $repository
     * @return	void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
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
                Rule::exists($this->repository->getModelTable(), 'email')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'password' => 'required|min:6',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        if ($this->invalid()) {
            throw new ValidationException($this);
        }

        $data = $this->validator->validated();

        // Make sure we can login with case insensitive email
        $data['email'] = strtolower($data['email']);

        return $data;
    }
}
