<?php

namespace Thtg88\MmCms\Http\Requests\Auth;

use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\UserRepository;

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
        $all_rules = [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($this->repository->getModelTable(), 'email')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:6|max:255',
        ];

        if (Config::get('mmcms.recaptcha.mode') === true) {
            $all_rules['g_recaptcha_response'] = 'bail|required|captcha';
        }

        return $all_rules;
    }
}
