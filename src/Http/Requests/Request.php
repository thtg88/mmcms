<?php

namespace Thtg88\MmCms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class Request extends FormRequest
{
    /**
	 * The request repository implementation.
	 *
	 * @var \Thtg88\MmCms\Repositories\Repository
	 */
	protected $repository;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Return whether the user is the owner of the resource concerning the
     * request or not.
     *
     * @return bool
     */
    protected function authorizeOwner()
    {
	    // Get resource
	    $resource = $this->repository->find($this->route('id'));

	    // Needs to be an existing resource
	    if($resource === null)
	    {
		    return false;
	    }

	    // Current user is the owner of the viewing
        return $this->user()->id == $resource->user_id;
    }

    /**
     * Return whether the user is a developer or not.
     *
     * @return bool
     */
    protected function authorizeDeveloper()
    {
	    return $this->authorizeRole(config('mmcms.roles.developer_role_name'));
    }

    /**
     * Return whether the user is the owner of the resource concerning the
     * request or not.
     *
     * @return bool
     */
    protected function authorizeRole($role_name)
    {
	    if(empty($role_name))
		{
			return false;
		}

		if(!is_string($role_name))
		{
			return false;
		}

		// Get user
	    $user = $this->user();

	    if($user === null)
	    {
		    return false;
	    }

		if($user->role === null)
		{
			return false;
		}

		if($user->role->name !== $role_name)
		{
			return false;
		}

        return true;
    }

    /**
     * Return whether the user is the owner of the resource concerning the
     * request or not.
     *
     * @return bool
     */
    protected function authorizeResourceExist()
    {
	    // Get resource
	    $resource = $this->repository->find($this->route('id'));

	    // Needs to be an existing resource
	    if($resource === null)
	    {
		    return false;
	    }

        return true;
    }

    protected function formatErrors(Validator $validator)
    {
	    return ['errors' => $validator->getMessageBag()->toArray()];
    }
}
