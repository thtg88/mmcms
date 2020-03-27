<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Thtg88\MmCms\Http\Requests\DestroyRequest;
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class DestroyRequest extends DestroyRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\ContentTypeRepository	$repository
     * @return	void
     */
    public function __construct(ContentTypeRepository $repository)
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
