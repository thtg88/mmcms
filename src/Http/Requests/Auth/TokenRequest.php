<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

// Requests
use Thtg88\MmCms\Http\Requests\Request;
// Repositories
use Thtg88\MmCms\Repositories\UserRepository;

class TokenRequest extends Request
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
            'refresh_token' => 'required|string',
        ];
    }
}
