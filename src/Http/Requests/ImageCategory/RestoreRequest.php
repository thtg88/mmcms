<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\ImageCategoryRepository;

class RestoreRequest extends Request
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageCategoryRepository $repository
     * @return void
     */
    public function __construct(ImageCategoryRepository $repository)
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
        return $this->authorizeResourceDeletedExist();
    }
}
