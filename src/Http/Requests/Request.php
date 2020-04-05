<?php

namespace Thtg88\MmCms\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
        if ($resource === null) {
            return false;
        }

        // Current user is the owner of the viewing
        return $this->user()->id == $resource->user_id;
    }

    /**
     * Determine if the resource from the route's id exists.
     *
     * @return bool
     */
    public function authorizeResourceExist()
    {
        // Find resource
        $resource = $this->findResource();

        return $resource !== null;
    }

    /**
     * Determine if the resource (even if deleted) exists.
     *
     * @return bool
     */
    public function authorizeResourceDeletedExist()
    {
        // Find resource
        $resource = $this->findResource(true);

        return $resource !== null;
    }

    /**
     * Determine if the resource from the route's id belongs
     * to the user performing the request.
     *
     * @return bool
     */
    public function authorizeResourceExistAndOwner()
    {
        // Find resource
        $resource = $this->findResource();

        return (
            $resource !== null &&
            $this->user() !== null &&
            $resource->user_id == $this->user()->id
        );
    }

    protected function formatErrors(Validator $validator)
    {
        return ['errors' => $validator->getMessageBag()->toArray()];
    }

    /**
     * Find the resource from the route's id.
     * Optionally include a trashed resource in the query.
     *
     * @param bool $with_trashed
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function findResource($with_trashed = false)
    {
        // Get id from route
        $resource_id = $this->route('id');

        // Find trashed resource
        if ($with_trashed === true) {
            return $this->repository->withTrashed()
                ->find($resource_id);
        }

        // Find resource
        return $this->repository->find($resource_id);
    }
}
