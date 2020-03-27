<?php

namespace Thtg88\MmCms\Http\Requests\ContentMigrationMethod;

use Thtg88\MmCms\Http\Requests\DestroyRequest as BaseDestroyRequest;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

class DestroyRequest extends BaseDestroyRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\ContentMigrationMethodRepository	$repository
     * @return	void
     */
    public function __construct(ContentMigrationMethodRepository $repository)
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
        if ($this->authorizeDeveloper() === false) {
            return false;
        }

        return $this->authorizeResourceExist();
    }
}
